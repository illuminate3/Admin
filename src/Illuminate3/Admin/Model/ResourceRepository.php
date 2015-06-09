<?php

namespace Illuminate3\Admin\Model;

use Illuminate3\Pages\Model\PageRepository;
use Event;

class ResourceRepository
{
	/**
	 * @param Resource $resource
	 * @param null     $title
	 * @param null     $color
	 * @return mixed
	 */
	static public function createWithPages(Array $data, $title = null, $color = '#31b0d5')
	{
		$resource = Resource::create($data);

		if(!$title) {
			$title = $resource->title;
		}

		$pages = PageRepository::createResourcePages($title, $resource->controller, null, 'layouts.admin', $color);

		Event::fire('admin.model.resourceRepository.createWithPages', array($resource, $pages));

		return $pages;
	}
}

