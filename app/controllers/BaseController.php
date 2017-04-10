<?php

class BaseController extends Controller
{
    protected $allowedTemplates = [];

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout)) {
			$this->layout = View::make($this->layout);
		}
	}

    /**
     * @param $template
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return mixed
     */
	protected function template($template)
    {
        if (!in_array($template, $this->allowedTemplates)) {
            throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        return View::make($template);
    }

}
