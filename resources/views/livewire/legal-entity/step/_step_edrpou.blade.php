<x-slot name="title">
    {{  __('forms.edrpou') }}
    <h3>  {{  __('forms.step', ['currentSteep' => $currentStep,'totalSteps' => $totalSteps]) }}</h3>
</x-slot>
<div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
    <x-forms.form-group>
        <x-slot name="label">
            <x-forms.label class="default-label" for="edrpou" name="label" >
                {{__('forms.edrpou_rnokpp')}} *
            </x-forms.label>
        </x-slot>
        <x-slot name="input">
            <x-forms.input maxlength="10" class="default-input" value="{{$edrpou ?? ''}}" wire:model="legal_entity_form.edrpou" type="text" id="edrpou"/>
        </x-slot>
        @error('legal_entity_form.edrpou')
        <x-slot name="error">
            <x-forms.error name="message">
                {{$message}}
            </x-forms.error>
        </x-slot>
        @enderror
    </x-forms.form-group>
</div>
