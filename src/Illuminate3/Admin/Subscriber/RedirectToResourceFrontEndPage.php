<?php

namespace Illuminate3\Admin\Subscriber;

use Illuminate\Events\Dispatcher as Events;
use Illuminate\Database\Eloquent\Model;
use Illuminate3\Crud\CrudController;
use Illuminate3\Admin\Controller\ResourceController;
use DeSmart\ResponseException\Exception as ResponseException;
use Str, Redirect;

class RedirectToResourceFrontEndPage
{
	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param Events $events
	 */
	public function subscribe(Events $events)
	{
		$events->listen('crud::saved', array($this, 'onSaved'));
	}

	/**
	 * @param Model          $model
	 * @param CrudController $controller
	 */
	public function onSaved(Model $model, CrudController $controller)
	{
		// We are only interested in a resource controller
		if(!$controller instanceof ResourceController) {
			return;
		}

		// Redirect to the newly created resource
		$route = Str::slug($model->title);
		ResponseException::chain(Redirect::route($route))->fire();
	}

}