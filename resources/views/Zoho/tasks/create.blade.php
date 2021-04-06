<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500"/>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors"/>

        <form method="POST" action="{{ route('task.post.create') }}">
        @csrf

        <!-- Name -->
            <div>
                <x-label for="subject" :value="__('Subject')"/>

                <x-input id="subject" class="block mt-1 w-full" type="text" name="subject" :value="old('subject')"
                         required autofocus/>
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="date" :value="__('Date')"/>

                <x-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')"/>
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="Lead" :value="__('Lead')"/>

                <select id="lead" class="block mt-1 w-full" name="lead">
                    @foreach($contacts as $contact)
                        <option value="{{ $contact['id'] }}-{{ $contact['Full_Name'] }}">{{ $contact['Full_Name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-label for="deal" :value="__('Deal')"/>

                <select id="deal" class="block mt-1 w-full" name="deal">
                    @foreach($deals as $deal)
                        <option value="{{ $deal['id'] }}-{{ $deal['Deal_Name'] }}">{{ $deal['Deal_Name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-label for="status" :value="__('Status')"/>

                <select id="status" class="block mt-1 w-full" name="status">
                    <option value="Not Started">Not Started</option>
                    <option value="Deferred">Deferred</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                    <option value="Waiting for input">Waiting for input</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="priority" :value="__('Priority')"/>

                <select id="priority" class="block mt-1 w-full" name="priority">
                    <option value="High">High</option>
                    <option value="Highest">Highest</option>
                    <option value="Low">Low</option>
                    <option value="Lowest">Lowest</option>
                    <option value="Normal">Normal</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="description" :value="__('Description')"/>

                <textarea id="description" class="block mt-1 w-full" name="description">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-button class="ml-4">
                    {{ __('Create') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
