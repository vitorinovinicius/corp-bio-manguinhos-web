<?php

namespace App\Http\Controllers;

use App\Models\Occurrence;

class RedirectController extends Controller
{
    /**
     * @var Occurrence
     */
    private $occurrence;


    /**
     * RedirectController constructor.
     * @param Occurrence $occurrence
     */
    public function __construct(Occurrence $occurrence)
    {
        $this->occurrence = $occurrence;
    }

    public function redirect_minify($id)
    {
        $occurrence = $this->occurrence->findOrFail($id);
        return redirect()->route('occurrences.tracert',$occurrence->uuid);
    }
}
