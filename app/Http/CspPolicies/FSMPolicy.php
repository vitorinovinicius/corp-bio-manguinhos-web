<?php

namespace App\Http\CspPolicies;

use Lcobucci\JWT\Signer\Key;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Value;

class FSMPolicy extends Basic
{
    public function configure()
    {
        parent::configure();

        // $this->addDirective(Directive::DEFAULT, "*.url.com.br");
        $this->addDirective(Directive::DEFAULT, "*.google.com");
        $this->addDirective(Directive::DEFAULT, "data:");

        $this->addDirective(Directive::SCRIPT, [
            "https://www.googletagmanager.com",
            Keyword::SELF,
            Keyword::UNSAFE_INLINE,
            Keyword::UNSAFE_EVAL
        ]);

        $this->addDirective(Directive::SCRIPT, "google-analytics.com");
        $this->addDirective(Directive::SCRIPT, "*.googleapis.com");
        $this->addDirective(Directive::SCRIPT, "http://router.project-osrm.org");
        $this->addDirective(Directive::SCRIPT, "https://unpkg.com");
        $this->addDirective(Directive::SCRIPT, "https://fonts.googleapis.com");

        $this->addDirective(Directive::IMG, "*.basemaps.cartocdn.com");
        $this->addDirective(Directive::IMG, "https://www.google-analytics.com");
        $this->addDirective(Directive::IMG, "data:");
        $this->addDirective(Directive::IMG, "https://unpkg.com");

        // Restringe os URLs que podem ser carregados usando interfaces de script
        $this->addDirective(Directive::CONNECT, "https://www.google-analytics.com");
        // $this->addDirective(Directive::CONNECT, "*.url.com.br");
        $this->addDirective(Directive::CONNECT, "https://unpkg.com");
        $this->addDirective(Directive::CONNECT, "https://cdnjs.cloudflare.com");
        $this->addDirective(Directive::CONNECT, "https://bernii.github.io");
        $this->addDirective(Directive::CONNECT, "https://fonts.googleapis.com");

        $this->addDirective(Directive::STYLE, [
            "fonts.googleapis.com",
            Keyword::SELF,
            Keyword::UNSAFE_INLINE
        ]);

        $this->addDirective(Directive::STYLE, "leafletjs.com");
        $this->addDirective(Directive::STYLE, "https://unpkg.com");
        $this->addDirective(Directive::STYLE, "https://cdn.jsdelivr.net");

        $this->addDirective(Directive::STYLE_ATTR,  Keyword::UNSAFE_INLINE);
        $this->addDirective(Directive::SCRIPT_ATTR,  Keyword::UNSAFE_INLINE);

        // especifica fontes válidas para <script> elementos JavaScript, mas não manipuladores de eventos de
        // script embutidos como onclick.
        $this->addDirective(Directive::SCRIPT_ELEM, [
            Keyword::SELF,
            Keyword::UNSAFE_INLINE
        ]);

        $this->addDirective(Directive::SCRIPT_ELEM, "*.googletagmanager.com");
        $this->addDirective(Directive::SCRIPT_ELEM, "*.google-analytics.com");
        $this->addDirective(Directive::SCRIPT_ELEM, "https://code.jquery.com");
        $this->addDirective(Directive::SCRIPT_ELEM, "https://maxcdn.bootstrapcdn.com");
        $this->addDirective(Directive::SCRIPT_ELEM, "https://cdn.datatables.net");
        $this->addDirective(Directive::SCRIPT_ELEM, "https://cdn.jsdelivr.net");


         // especifica fontes validas para tags <link> que requisita acesso de css externos
         $this->addDirective(Directive::STYLE_ELEM, [
            Keyword::SELF,
            Keyword::UNSAFE_INLINE
        ]);

        $this->addDirective(Directive::STYLE_ELEM, "https://cdn.datatables.net");
        $this->addDirective(Directive::STYLE_ELEM, "https://maxcdn.bootstrapcdn.com");

         // directive prevents loading any assets over HTTP when the page uses HTTPS.
         $this->addDirective(Directive::BLOCK_ALL_MIXED_CONTENT, Value::NO_VALUE);

         // Instructs user agents to treat all of a site's insecure URLs (those served over HTTP) as though they have
         // been replaced with secure URLs (those served over HTTPS). This directive is intended for web sites with
         // large numbers of insecure legacy URLs that need to be rewritten
         $this->addDirective(Directive::UPGRADE_INSECURE_REQUESTS, Value::NO_VALUE);

    }
}