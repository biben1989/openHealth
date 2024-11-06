<?php

namespace App\Livewire\LegalEntity;

use Illuminate\Support\Arr;

class EditLegalEntity extends LegalEntities
{

    public function mount(): void
    {
        parent::mount(); // TODO: Change the autogenerated stub
        $this->getLegalEntityForm();
    }

    /**
     * Retrieves the legal entity form data.
     */
    public function getLegalEntityForm(): void
    {
        parent::getLegalEntity(); // Call the parent method to retrieve basic legal entity data
        $this->getLicenseForm(); // Get the license form data
        $this->getArchiveForm(); // Get the archive form data
        $this->getOwnerLegalEntity(); // Get the owner's legal entity data
    }

    /**
     * Retrieves and sets only specific fields related to the license from the legal entity form.
     */
    public function getLicenseForm(): void
    {
        // Select and assign specific fields related to the license
        $this->legal_entity_form->license = Arr::only($this->legal_entity_form->license,
            [
                'type',
                'license_number',
                'issued_by',
                'issued_date',
                'expiry_date',
                'active_from_date',
                'what_licensed',
                'order_no'
            ]);
    }

    /**
     * Retrieves and formats specific fields from the archive form.
     */
    public function getArchiveForm(): void
    {

        // Extracting only 'date' and 'place' fields from the first element of the archive
        if (!empty($this->legal_entity_form->archive)) {
            $this->legal_entity_form->archive = Arr::only($this->legal_entity_form->archive[0],
                [
                    'date',
                    'place',
                ]);
        }

    }


    public function getOwnerLegalEntity(): void
    {
        $owner = $this->legalEntity->getOwner();

        if ($owner->exists()) {
            $ownerArray = $owner->toArray();
            $ownerParty = $ownerArray['party'] ?? [];
            $ownerPosition = $ownerArray['position'] ?? null;
            $this->legal_entity_form->owner = array_merge($this->legal_entity_form->owner ?? [], [
                'first_name'  => $ownerParty['first_name'] ?? null,
                'last_name'   => $ownerParty['last_name'] ?? null,
                'second_name' => $ownerParty['second_name'] ?? null,
                'gender'      => $ownerParty['gender'] ?? null,
                'birth_date'  => $ownerParty['birth_date'] ?? null,
                'no_tax_id'   => $ownerParty['no_tax_id'] ?? null,
                'tax_id'      => $ownerParty['tax_id'] ?? null,
                'documents'   => $ownerParty['documents'][0] ?? null,
                'phones'      => $ownerParty['phones'] ?? null,
                'position'    => $ownerPosition,
            ]);
        }
        //TODO: Check if owner exists or not add call request to get owner
//        return  EmployeeRequestApi::getEmployeeRequestsList(['legal_entity', $this->legalEntity->uuid]);
    }


    //TODO: Call request to update legal entity
    public function updateLegalEntity(): void
    {
        $this->resetErrorBag();
        $this->validateUpdateLegalEntity();
        $this->stepPublicOffer();
        //TODO: Call request to update legal entity
    }


    public function render()
    {
        return view('livewire.legal-entity.edit-legal-entity');
    }

}
