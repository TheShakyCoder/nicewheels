<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\EbayItemService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Ramsey\Uuid\Uuid;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $tokens = config('common.user.tokens');

        //  create User
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'api_token' => (string)\Uuid::generate(4)
        ]);

        //  create complimentary transaction
        $transaction = $user->transactions()->create([
            'reference' => 'COMPLIMENTARY REDEMPTIONS',
            'amount' => 0,
            'tokens' => $tokens,
            'remaining' => 0
        ]);

        //  create random redemptions
        $ebayItemService = new EbayItemService();
        $ebayItemService->getPublicEbayItems(0, $tokens)->each(function($ebayItem) use($user, $transaction) {
            $user->redemptions()->create([
                'ebay_item_id' => $ebayItem->id,
                'amount' => $ebayItem->final_amount,
                'transaction_id' => $transaction->id
            ]);
        });

        return $user;
    }
}
