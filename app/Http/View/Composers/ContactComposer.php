<?php

namespace App\Http\View\Composers;

use App\Models\Contact;
use Illuminate\View\View;

class ContactComposer
{
    /**
     * The user repository implementation.
     *
     * @var Contact
     */
    protected $contacts;

    /**
     * Create a new profile composer.
     *
     * @param  Contact  $contacts
     * @return void
     */
    public function __construct(Contact $contacts)
    {
        // Dependencies automatically resolved by service container...
        $this->contacts = $contacts;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('contacts', $this->contacts->all());
    }
}
