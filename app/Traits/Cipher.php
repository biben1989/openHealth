<?php

namespace App\Traits;

use App\Classes\Cipher\Api\CipherApi;
use App\Classes\Cipher\Exceptions\ApiException;
use App\Classes\Cipher\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

trait Cipher
{
    // КНЕДП
    public ?string $knedp;

    public $keyContainerUpload;

    public string $password;

    public mixed $getCertificateAuthority;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'knedp'                                  => 'required|string',
            'keyContainerUpload'                     => 'required|file',
            'password'                               => 'required|string|max:255',
            'legal_entity_form.public_offer.consent' => 'required|accepted',
        ];
    }

    //Send Encrypted Data
    protected function sendEncryptedData(array $data, string $signatoryInitiator = CipherApi::SIGNATORY_INITIATOR_PERSON): string|array
    {
        $this->validate($this->rules());

        return (new CipherApi())->sendSession(
            json_encode($data),
            $this->password,
            $this->convertFileToBase64(),
            $this->knedp,
            $signatoryInitiator
        );
    }

    //Convert KEP to Base64
    public function convertFileToBase64(): ?string
    {
        if ($this->keyContainerUpload && $this->keyContainerUpload->exists()) {
            $fileExtension = $this->keyContainerUpload->getClientOriginalExtension();
            $filePath = $this->keyContainerUpload->storeAs('uploads/kep', 'kep.' . $fileExtension, 'public');
            if ($filePath) {
                $fileContents = file_get_contents(storage_path('app/public/' . $filePath));
                if ($fileContents !== false) {
                    $base64Content = base64_encode($fileContents);
                    Storage::disk('public')->delete($filePath);
                    return $base64Content;
                }
            }
        }
        return null;
    }

    //Get Certificate Authority

    /**
     * @throws ApiException
     */
    public function getCertificateAuthority(): array
    {
        if (!Cache::has('knedp_certificate_authority')) {
            $data = (new Request('get', '/certificateAuthority/supported', ''))->sendRequest();
            if ($data === false) {
                throw new \RuntimeException('Failed to fetch data from the API.');
            }
            $this->getCertificateAuthority = Cache::put('knedp_certificate_authority', $data['ca'], now()->addDays(7));
        }
        return $this->getCertificateAuthority = Cache::get('knedp_certificate_authority');
    }
}
