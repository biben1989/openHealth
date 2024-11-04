<?php

namespace App\Livewire\Patient\Forms;

use App\Rules\AgeCheck;
use App\Rules\Cyrillic;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PatientFormRequest extends Form
{
    #[Validate([
        'patient.first_name' => ['required', 'min:3', new Cyrillic()],
        'patient.last_name' => ['required', 'min:3', new Cyrillic()],
        'patient.second_name' => ['nullable', 'min:3', new Cyrillic()],
        'patient.birth_date' => ['required', 'date', new AgeCheck()],
        'patient.country_of_birth' => ['required', 'string'],
        'patient.city_of_birth' => ['required', 'string'],
        'patient.gender' => ['required', 'string'],
    ])]
    public ?array $patient = [];

    #[Validate([
        'documents.type' => ['required', 'string'],
        'documents.number' => ['required', 'string'],
        'documents.issued_by' => ['required', 'string'],
        'documents.issued_at' => ['required', 'date'],
        'documents.valid_to' => ['nullable', 'date'],
        'documents.unzr' => ['nullable', 'string'],
    ])]
    public ?array $documents = [];

    #[Validate([
        'identity.tax_id' => ['required', 'string', 'max:10'],
    ])]
    public ?array $identity = [];

    #[Validate([
        'contact_data.phones.*.type' => ['nullable', 'string'],
        'contact_data.phones.*.number' => ['nullable', 'string', 'min:13', 'max:13'],
        'contact_data.email' => ['nullable', 'email', 'string'],
        'contact_data.preferred_contact_method' => ['nullable', 'string'],
        'contact_data.secret' => ['required', 'string'],
    ])]
    public ?array $contact_data = [];

    #[Validate([
        'emergency_contact.first_name' => ['required', 'min:3', new Cyrillic()],
        'emergency_contact.last_name' => ['required', 'min:3', new Cyrillic()],
        'emergency_contact.second_name' => ['nullable', 'min:3', new Cyrillic()],
        'emergency_contact.phones.*.type' => ['required', 'string'],
        'emergency_contact.phones.*.number' => ['required', 'string', 'min:13', 'max:13'],
    ])]
    public ?array $emergency_contact = [];

    #[Validate([
        'address.region' => ['required', 'string'],
        'address.city' => ['required', 'string'],
        'address.street_type' => ['required', 'string'],
        'address.street_name' => ['required', 'string'],
        'address.building' => ['required', 'string'],
        'address.apartment' => ['required', 'string'],
        'address.zip_code' => ['nullable', 'string'],
    ])]
    public ?array $address = [];

    #[Validate([
        'legal_representative.relation_type' => ['required', 'string'],
        'legal_representative.first_name' => ['required', 'min:3', new Cyrillic()],
        'legal_representative.last_name' => ['required', 'min:3', new Cyrillic()],
        'legal_representative.second_name' => ['nullable', 'min:3', new Cyrillic()],
        'legal_representative.birth_date' => ['required', 'date', new AgeCheck()],
        'legal_representative.country_of_birth' => ['required', 'string'],
        'legal_representative.city_of_birth' => ['required', 'string'],
        'legal_representative.tax_id' => ['nullable', 'string', 'max:10'],
        'legal_representative.unzr' => ['nullable', 'string'],
    ])]
    public ?array $legal_representative = [];

    #[Validate([
        'person_documents.type' => ['required', 'string'],
        'person_documents.number' => ['required', 'string'],
        'person_documents.issued_by' => ['required', 'string'],
        'person_documents.issued_at' => ['required', 'date'],
        'person_documents.valid_to' => ['nullable', 'date'],
    ])]
    public ?array $person_documents = [];

    #[Validate([
        'legal_representation_documents.type' => ['required', 'string'],
        'legal_representation_documents.number' => ['required', 'string'],
        'legal_representation_documents.issued_by' => ['required', 'string'],
        'legal_representation_documents.issued_at' => ['required', 'date'],
    ])]
    public ?array $legal_representation_documents = [];

    #[Validate([
        'legal_representation_contact.phones.*.type' => ['nullable', 'string'],
        'legal_representation_contact.phones.*.number' => ['nullable', 'string', 'min:13', 'max:13'],
        'legal_representation_contact.email' => ['nullable', 'email', 'string'],
        'legal_representation_contact.preferred_contact_method' => ['nullable', 'string'],
    ])]
    public ?array $legal_representation_contact = [];

    /**
     * @throws ValidationException
     */
    public function rulesForModelValidate(string $model): array
    {
        return $this->validate($this->rulesForModel($model)->toArray());
    }
}
