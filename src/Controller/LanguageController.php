<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LanguageController
 */
class LanguageController extends AppController
{
    /**
     * Before action.
     *
     * @param Request|null $request
     * @return mixed
     */
    public function beforeAction(Request $request = null/*, Response $response = null*/)
    {
        return null;
    }

    /**
     * Language controller main function.
     *
     * @return RedirectResponse
     */
    public function language()
    {
        $lang = $this->request->query->get('lang');
        $this->session->set('lang', $lang);
        $referer = $this->request->headers->get('referer');
        return $this->redirect($referer, false);
    }
}
