<?php

declare(strict_types=1);

namespace FMDD\SyliusSortingPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class SortingMenuBuilder
{
	public function buildMenu(MenuBuilderEvent $event): void
	{
		$sales = $event
			->getMenu()
			->getChild('catalog');

		if ($sales !== null) {
			$sales
				->addChild('sorting', [
					'route' => 'fmdd_sylius_admin_sorting_index',
				])
				->setName('fmdd.ui.sorting_plugin.product.menuTitle')
				->setLabelAttribute('icon', 'sort');
		}
	}
}
