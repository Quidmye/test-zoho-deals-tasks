<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('deal.post.create') }}">
        @csrf

        <!-- Name -->
            <div>
                <x-label for="dname" :value="__('Deal Name')" />

                <x-input id="dname" class="block mt-1 w-full" type="text" name="dname" :value="old('dname')" required autofocus />
            </div>

            <div class="mt-4">
                <x-label for="account" :value="__('Account')"/>

                <select id="account" class="block mt-1 w-full" name="account" required>
                    @foreach($accounts as $account)
                        <option value="{{ $account['id'] }}-{{ $account['Account_Name'] }}">{{ $account['Account_Name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-label for="dtype" :value="__('Type')"/>

                <select id="dtype" class="block mt-1 w-full" name="dtype">
                    <option value="">None</option>
                    <option value="Existing Business">Existing Business</option>
                    <option value="New Business">New Business</option>
                </select>
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="nstep" :value="__('Next Step')" />

                <x-input id="nstep" class="block mt-1 w-full" type="text" name="nstep" />
            </div>

            <div class="mt-4">
                <x-label for="lsource" :value="__('Lead Source')"/>

                <select id="lsource" class="block mt-1 w-full" name="lsource">
                    <option value="">None</option>
                    <option value="Advertisement">Advertisement</option>
                    <option value="Cold Call">Cold Call</option>
                    <option value="Employee Referral">Employee Referral</option>
                    <option value="External Referral">External Referral</option>
                    <option value="Online Store">Online Store</option>
                    <option value="Partner">Partner</option>
                    <option value="Public Relations">Public Relations</option>
                    <option value="Sales Email Alias">Sales Email Alias</option>
                    <option value="Seminar Partner">Seminar Partner</option>
                    <option value="Internal Seminar">Internal Seminar</option>
                    <option value="Trade Show">Trade Show</option>
                    <option value="Web Download">Web Download</option>
                    <option value="Web Research">Web Research</option>
                    <option value="Chat">Chat</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="contact" :value="__('Contact')"/>

                <select id="contact" class="block mt-1 w-full" name="contact">
                    <option value="">None</option>
                @foreach($contacts as $contact)
                        <option value="{{ $contact['id'] }}-{{ $contact['Full_Name'] }}">{{ $contact['Full_Name'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-label for="amount" :value="__('Amount')" />

                <x-input id="amount" class="block mt-1 w-full" type="text" name="amount" :value="old('amount')" onchange="handleAmount()" />
            </div>

            <div class="mt-4">
                <x-label for="cdate" :value="__('Closing Date')"/>

                <x-input id="cdate" class="block mt-1 w-full" type="date" name="cdate" :value="old('cdate')" required/>
            </div>

            <div class="mt-4">
                <x-label for="stage" :value="__('Stage')"/>

                <select id="stage" class="block mt-1 w-full" name="stage" onchange="handleChange()">
                    <option data-stage="10" value="Qualification">Qualification</option>
                    <option data-stage="20" value="Needs Analysis">Needs Analysis</option>
                    <option data-stage="40" value="Value Proposition">Value Proposition</option>
                    <option data-stage="60" value="Identify Decision Makers">Identify Decision Makers</option>
                    <option data-stage="75" value="Proposal/Price Quote">Proposal/Price Quote</option>
                    <option data-stage="90" value="Negotiation/Review">Negotiation/Review</option>
                    <option data-stage="100" value="Closed Won">Closed Won</option>
                    <option data-stage="0" value="Closed Lost">Closed Lost</option>
                    <option data-stage="0" value="Closed-Lost to Competition">Closed-Lost to Competition</option>
                </select>
            </div>

            <div class="mt-4">
                <x-label for="probability" :value="__('Probability (%)')"/>

                <x-input id="probability" class="block mt-1 w-full" type="text" name="probability" :value="old('cdate')"/>
            </div>

            <div class="mt-4">
                <x-label for="revenue" :value="__('Expected Revenue')"/>

                <x-input id="revenue" class="block mt-1 w-full" type="text" name="revenue" :value="old('revenue')" redonly/>
            </div>

            <div class="mt-4">
                <x-label for="description" :value="__('Description')"/>

                <textarea id="description" class="block mt-1 w-full" name="description">{{ old('description') }}</textarea>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
<script>
    function handleAmount(){
        let amount = +document.getElementById("amount").value;
        let probability = +document.getElementById("probability").value;
        if(amount && probability){
            document.getElementById('revenue').value = (amount/100) * probability;
        }
    }
    function handleChange(){
        let selectBox = document.getElementById("stage");
        let val = selectBox.options[selectBox.selectedIndex].dataset.stage;
        document.getElementById('probability').value = val;
        handleAmount();
    };
    document.addEventListener('DOMContentLoaded', () => handleChange());
</script>
