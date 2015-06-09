<?php

namespace Illuminate3\Admin\Controller;

use Illuminate3\Crud\CrudController;
use Illuminate3\Form\FormBuilder;
use Illuminate3\Model\ModelBuilder;
use Illuminate3\Overview\OverviewBuilder;
use Route, View, Input, App, Str, Artisan;

use Illuminate3\Pages\Model\Page;
use Illuminate3\Admin\Model\Resource;
use Illuminate3\Admin\Model\App as AdminApp;


class ResourceController extends CrudController
{
	/**
	 * @param FormBuilder $fb
	 */
	public function buildForm(FormBuilder $fb)
	{
		$fb->text('title')
           ->label('Title')
           ->help('What is the name of the resource? Examples are: "Article", "Category". For good semantics, please use a singular form.')
           ->required();
        
		$fb->textarea('description')
           ->label('Description')
           ->help('Give a description of this resource. This will be used to help other users understand what this resource is about.')
           ->rows(3);

		$fb->text('controller')->rules('unique:resources');
		$fb->text('path');
	}

	/**
	 * @param ModelBuilder $mb
	 */
	public function buildModel(ModelBuilder $mb)
	{
		$mb->name('Illuminate3\Admin\Model\Resource')->table('resources');
	}

	/**
	 * @param OverviewBuilder $ob
	 */
	public function buildOverview(OverviewBuilder $ob)
	{
		$ob->fields(array('title', 'controller', 'path'));
	}

	/**
	 * @return array
	 */
	public function config()
	{
		return array(
			'title' => 'Resource',
		);
	}

	/**
	 * @param Resource $resource
	 */
//	public function onSaved(Resource $resource)
//	{
//		if(Input::get('create_admin')) {
//			Event::fire('admin.resources.createAdmin', compact('resource'));
////			$pages = $this->generateAdmin($resource);
//		}
//
//		if(Input::get('create_app')) {
//			Event::fire('admin.resources.createApp', compact('resource'));
////			$alias = $pages['index']->alias;
////			if(!AdminApp::whereRoute($alias)->first()) {
////				AdminApp::create(array(
////					'title' => $resource->title,
////					'route' => $alias,
////					'icon_class' => 'icon-file',
////				));
////			}
//		}
//
//		if(Input::get('create_front')) {
//			Event::fire('admin.resources.createFront', compact('resource'));
////			$pages = $this->generateFront($resource);
//		}
//	}

}

