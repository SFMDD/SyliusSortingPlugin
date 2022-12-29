<?php

declare(strict_types=1);

namespace FMDD\SyliusSortingPlugin\Controller;

use App\Command\CronTab\EnableTaxonIfProductsCommand;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Model\ProductTaxonInterface;
use Sylius\Component\Core\Repository\ProductTaxonRepositoryInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class TaxonSortingController
{
	private Environment $twig;
	private TaxonRepositoryInterface $taxonRepository;
	private EntityManagerInterface $entityManager;
	private EventDispatcherInterface $eventDispatcher;
	private RouterInterface $router;
	private FlashBagInterface $flashBag;
	private TranslatorInterface $translator;

	public function __construct(
		Environment $twig,
		TaxonRepositoryInterface $taxonRepository,
		EntityManagerInterface $entityManager,
		EventDispatcherInterface $eventDispatcher,
		RouterInterface $router,
		FlashBagInterface $flashBag,
		TranslatorInterface $translator
	) {
		$this->twig = $twig;
		$this->taxonRepository = $taxonRepository;
		$this->entityManager = $entityManager;
		$this->eventDispatcher = $eventDispatcher;
		$this->router = $router;
		$this->flashBag = $flashBag;
		$this->translator = $translator;
	}

	public function index(): Response
	{
		return new Response(
			$this->twig->render(
				'@FMDDSyliusSortingPlugin/Taxon/index.html.twig'
			)
		);
	}

	public function taxons(int $taxonId): Response
	{
		$taxon = $this->taxonRepository->find($taxonId);
		if ($taxon === null) {
			throw new NotFoundHttpException();
		}

		$taxons = $this->taxonRepository->findBy(['parent' => $taxon], ['position' => 'asc']);

		return new Response(
			$this->twig->render(
				'@FMDDSyliusSortingPlugin/Taxon/index.html.twig',
				[
					'taxon' => $taxon,
					'taxons' => $taxons,
				]
			)
		);
	}

	public function savePositions(Request $request): RedirectResponse
	{
		$i = 0;
		$taxon = null;

		if ($request->request->get('id') !== null) {
			foreach ($request->request->get('id') as $id) {
				$temp = $this->taxonRepository->find($id);
				if($temp !== null) {
					$temp->setPosition($i);
					$this->entityManager->persist($temp);
					$this->entityManager->flush();

					if ($taxon === null) {
						$taxon = $temp;
					}
					++$i;
				}
			}
		}

		if ($taxon !== null) {
			$message = $this->translator->trans('fmdd.ui.sorting_plugin.taxon.successMessage');
			$this->flashBag->add('success', $message);

			$redirectUrl = $this->router->generate('fmdd_sylius_admin_taxons_sorting', ['taxonId' => $taxon->getParent()->getId()]);

			// Eg. for update product position in elasticsearch
			$event = new GenericEvent($taxon);
			$this->eventDispatcher->dispatch('fmdd-sylius-sorting-products-after-persist', $event);
		} else {
			$message = $this->translator->trans('fmdd.ui.sorting_plugin.taxon.noTaxonMessage');
			$this->flashBag->add('error', $message);

			$redirectUrl = $this->router->generate('fmdd_sylius_admin_taxons_sorting_index');
		}

		return new RedirectResponse($redirectUrl);
	}
}
