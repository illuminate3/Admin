<?php

namespace Illuminate3\Admin\Subscriber;

use Illuminate3\Crud\CrudController;
use Illuminate3\Admin\Controller\ResourceController;
use Illuminate\Events\Dispatcher as Events;
use Illuminate\Database\Eloquent\Model;
use Illuminate3\Navigation\Model\Node;
use Illuminate3\Pages\Model\Page;
use NavigationContainersTableSeeder;
use Illuminate3\Form\FormBuilder;
use Input, Str;

class AddDashboardNavigationForResource
{
	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param Events $events
	 */
	public function subscribe(Events $events)
	{
		$events->listen('crud::saved', array($this, 'onSaved'));
		$events->listen('form.formBuilder.build.before', array($this, 'onBuildForm'));
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

		// When the form is posted, we need this field.
		// If it is not checked, then we don't have to do anything.
		if(!Input::get('create_dashboard_navigation')) {
			return;
		}

        // Add a dashboard app pointing to the 'create' route of this resource
		Node::create(array(
			'title' => sprintf('Create %s', Str::lower($model->title)),
			'description' => Input::get('description'),
			'page_id' => Page::whereAlias(sprintf('admin.%s.create', Str::slug($model->title)))->first()->id,
			'icon_class' => 'icon-file',
			'container_id' => NavigationContainersTableSeeder::DASHBOARD,
		));

	}

	/**
	 * @param FormBuilder $fb
	 */
	public function onBuildForm(FormBuilder $fb)
	{
		if($fb->getName() != 'Illuminate3\Admin\Controller\ResourceController') {
			return;
		}

		$fb->checkbox('create_dashboard_navigation')
			->choices(array(1 => 'Create dashboard app'))
			->map(false)
			->value(array(1))
			->help('This option will add the resource to the dashboard.');
	}
}