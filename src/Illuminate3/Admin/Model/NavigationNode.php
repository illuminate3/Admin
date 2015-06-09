<?php

namespace Illuminate3\Admin\Model;

use Illuminate3\Navigation\Model\Node;

class NavigationNode extends Node
{
	/**
	 * @param $value
	 * @return string
	 */
	public function getColorAttribute($value)
	{
		$preference = $this->page->userPreference;
		return $preference && $preference->color ? $preference->color : '#31b0d5';
	}

	/**
	 * @param $value
	 * @return string
	 */
	public function getIconClassAttribute($value)
	{
		$preference = $this->page->userPreference;
		return $preference && $preference->icon_class ? $preference->icon_class : 'icon-file';
	}

	/**
	 * @return Page
	 */
	public function page()
	{
		return $this->belongsTo('Illuminate3\Admin\Model\Page');
	}

}

