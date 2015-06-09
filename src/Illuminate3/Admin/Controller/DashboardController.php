<?php

namespace Illuminate3\Admin\Controller;

use Illuminate3\Crud\CrudController;
use Illuminate3\Form\FormBuilder;
use Illuminate3\Model\ModelBuilder;
use Illuminate3\Overview\OverviewBuilder;
use Illuminate3\Navigation\Model\Container;

class DashboardController extends CrudController
{
    /**
     * @param FormBuilder $fb
     */
    public function buildForm(FormBuilder $fb)
    {
		$fb->text('title')->label('Title');
		$fb->textarea('description')->label('Description')->rows(3);
		$fb->modelSelect('page_id')->model('Illuminate3\Pages\Model\Page')->label('Page');
		$fb->hidden('container_id')->value($this->getContainer()->id);
		$fb->text('icon_class')->label('Icon class');
    }

    /**
     * @param ModelBuilder $mb
     */
    public function buildModel(ModelBuilder $mb)
    {
        $mb->name('Illuminate3\Navigation\Model\Node')->table('navigation_nodes');
    }

    /**
     * @param OverviewBuilder $ob
     */
    public function buildOverview(OverviewBuilder $ob)
    {
		$ob->getQueryBuilder()->whereContainerId($this->getContainer()->id);
    }

	/**
	 * @return Container
	 */
	public function getContainer()
	{
		return Container::whereName('dashboard')->first();
	}

}

