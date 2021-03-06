<?php

/**
 * This file is part of the Nextras community extensions of Nette Framework
 *
 * @license    MIT
 * @link       https://github.com/nextras
 * @author     Jan Skrasek
 */

namespace Nextras\Forms\Controls;

use Nette;
use Nette\Forms;
use Nextras\Forms\Controls\Fragments\ComponentControlTrait;


/**
 * Form control for autocomplete.
 *
 * @author   Jan Skrasek
 */
class Typeahead extends Forms\Controls\TextInput implements Nette\Application\UI\ISignalReceiver
{
	use ComponentControlTrait;

	/** @var Nette\Utils\Callback */
	protected $callback;


	public function __construct($caption = NULL, $callback = NULL)
	{
		parent::__construct($caption);
		$this->control->addClass('typeahead');
		$this->setCallback($callback);
	}


	protected function attached($component)
	{
		parent::attached($component);
		if ($component instanceof Nette\Application\IPresenter) {
			$this->control->{'data-typeahead-url'} = $this->link('autocomplete!');
		}
	}


	public function handleAutocomplete($q)
	{
		if (!$this->callback) {
			throw new Nette\InvalidStateException('Undefined Typehad callback.');
		}

		$this->getPresenter()->sendJson(Nette\Utils\Callback::invokeArgs($this->callback, [$q]));
	}


	public function setCallback($callback)
	{
		$this->callback = $callback;
	}

}
