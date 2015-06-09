<?php

namespace Illuminate3\Admin\Subscriber;

use Illuminate3\Admin\Controller\ResourceController;
use Illuminate3\Admin\Model\ResourceRepository;
use Illuminate\Events\Dispatcher as Events;
use Illuminate\Database\Eloquent\Model;
use Illuminate3\Crud\CrudController;
use Illuminate3\Form\FormBuilder;
use Illuminate3\Pages\Model\PageRepository;
use DeSmart\ResponseException\Exception as ResponseException;
use Input, App, Redirect, Route, Event;

class AddGenerateAdminHookToResource
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

		// Start up the generator
		$generator = App::make('Illuminate3\Crud\ControllerGenerator');
		$generator->setClassName($model->controller);
		$generator->setModelClass(str_replace('Resource', '', $model->controller));

		// Determine the file name
		$filename = $model->path . '/' . str_replace('\\', '/', $model->controller) . '.php';

		// Write the new controller file to the controller folder
		@mkdir(dirname($filename), 0755, true);
		file_put_contents($filename, $generator->generate());

		// Create the resource pages
		$pages = PageRepository::createResourcePages($model->title, $model->controller);

		require_once $filename;

		// Get the newly create controller and get the modelBuilder
		// We need to trigger the model generate event so that the model is
		// actually generated
		$crud = App::make($model->controller);
		Event::fire('model.builder.generate', $crud->init('create')->getModelBuilder());

	}
}