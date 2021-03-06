<?php
namespace RobertLemke\Example\Bookshop\Controller;

/*                                                                        *
 * This script belongs to the Flow package "RobertLemke.Example.Bookshop".*
 *                                                                        *
 *                                                                        */

use RobertLemke\Example\Bookshop\Domain\Model\Book;
use TYPO3\Flow\Annotations as Flow;

use TYPO3\Flow\Mvc\Controller\ActionController;
use TYPO3\Fluid\View\AbstractTemplateView;
use TYPO3\Media\Domain\Model\Adjustment\ResizeImageAdjustment;
use TYPO3\Media\Domain\Model\ImageVariant;
use TYPO3\Media\Domain\Repository\AssetRepository;

/**
 * Book controller for the RobertLemke.Example.Bookshop package
 *
 * @Flow\Scope("singleton")
 */
class GalleryController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \RobertLemke\Example\Bookshop\Domain\Repository\BookRepository
	 */
	protected $bookRepository;

	/**
	 * @Flow\Inject
	 * @var \RobertLemke\Example\Bookshop\Domain\Repository\CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * @Flow\Inject
	 * @var \RobertLemke\Example\Bookshop\Domain\Model\Basket
	 */
	protected $basket;

	/**
	 * @Flow\Inject
	 * @var AssetRepository
	 */
	protected $assetRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * A hacky way to implement a menu
	 *
	 * @return void
	 */
	public function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
		$view->assign('controller', array('gallery' => TRUE));
		$view->assign('categories', $this->categoryRepository->findAll());
		$view->assign('basket', $this->basket);
	}

	/**
	 * Shows a gallery of book covers
	 *
	 * @return void
	 */
	public function indexAction() {
		$books = $this->bookRepository->findAll();
		$this->view->assign('books', $books);
	}

	/**
	 * Shows a single book object
	 *
	 * @param Book $book The book to show
	 * @return void
	 */
	public function showAction(Book $book) {
		$image = $book->getImage();
		$variants = $image->getVariants();

		$this->persistenceManager->persistAll();
		$this->view->assign('book', $book);
		$this->view->assign('imageVariant', count($variants) ? current($variants) : NULL);
	}

}

?>