<?php

namespace Illuminate3\Admin\Model;

use Illuminate3\Pages\Model\Page as BasePage;
use Sentry;

class Page extends BasePage
{
	/**
	 * @return Illuminate3\Admin\Model\PagePreference
	 */
	public function userPreference()
	{
		$userId = Sentry::check() ? Sentry::getUser()->id : -1;

		return $this->hasOne('Illuminate3\Admin\Model\PagePreference', 'page_id')->where('user_id', '=', $userId);
	}

}

