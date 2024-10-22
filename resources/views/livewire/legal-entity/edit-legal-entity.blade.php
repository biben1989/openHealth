<div>


    <x-section-navigation x-data="{ showFilter: false }" class="">
        <x-slot  name="title">{{ __('Редагувати заклад ') }}</x-slot>
    </x-section-navigation>
    <div class="p-4 mb-4 bg-white border border-gray-200  shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800" >

        <x-forms.forms-section submit="">

            <x-slot name="description">
                {{  __('forms.step', ['currentSteep' => $currentStep,'totalSteps' => $totalSteps]) }}
            </x-slot>
            <x-slot name="form">
                <div class="grid-cols-1">
                    <div class="p-6.5">
                        @foreach($steps as $key=>$view)

                                @include('livewire.legal-entity.step.'.$view['view'])
                        @endforeach
                    </div>
                </div>
            </x-slot>
        </x-forms.forms-section>
    </div>
</div>
