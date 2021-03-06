<?php

namespace Combodo\iTop\Application\UI\Base\Component\DataTable\StaticTable;

use Combodo\iTop\Application\UI\Base\Layout\UIContentBlock;
use Combodo\iTop\Application\UI\Base\tJSRefreshCallback;
use utils;

/**
 * @copyright   Copyright (C) 2010-2020 Combodo SARL
 * @license     http://opensource.org/licenses/AGPL-3.0
 */

/**
 * Tables with static data
 * Class StaticTable
 */
class StaticTable extends UIContentBlock
{
	use tJSRefreshCallback;

	// Overloaded constants
	public const BLOCK_CODE = 'ibo-datatable';
	public const DEFAULT_HTML_TEMPLATE_REL_PATH = 'base/components/datatable/static/layout';
	public const DEFAULT_JS_ON_READY_TEMPLATE_REL_PATH = 'base/components/datatable/static/layout';
	public const DEFAULT_JS_FILES_REL_PATH = [
		'lib/datatables/js/jquery.dataTables.min.js',
		'lib/datatables/js/dataTables.bootstrap.min.js',
		'lib/datatables/js/dataTables.fixedHeader.min.js',
		'lib/datatables/js/dataTables.responsive.min.js',
		'lib/datatables/js/dataTables.scroller.min.js',
		'lib/datatables/js/dataTables.select.min.js',
		'js/dataTables.main.js',
		'js/dataTables.settings.js',
		'js/dataTables.pipeline.js',
	];

	/**
	 * @var array of 'entry name' => [
	 *  'description' => tooltip,
	 *  'label' => label to display,
	 *  'class' => cell CSS class,
	 *  'metadata' => [key => value] transformed into data-key="value"
	 * ]
	 */
	private $aColumns;

	/**
	 * @var array of [
	 *  '@class' => css class of the row,
	 *  'entry name' => [
	 *      'value_html' => value to display in the cell,
	 *      'value_raw' => real value put into data-value-raw
	 *  ], ...
	 * ]
	 */
	private $aData;
	private $aExtraParams;
	/*@var string $sUrlForRefresh*/
	private $sFilter;

	public function __construct(string $sId = null, array $aContainerCSSClasses = [], array $aExtraParams = [])
	{
		parent::__construct($sId, $aContainerCSSClasses);
		$this->aColumns = [];
		$this->aData = [];
		$this->aExtraParams = $aExtraParams;
	}

	/**
	 * @return array
	 */
	public function GetColumns(): array
	{
		return $this->aColumns;
	}

	/**
	 * @param array $aColumns
	 */
	public function SetColumns(array $aColumns): void
	{
		$this->aColumns = $aColumns;
	}

	/**
	 * @return array
	 */
	public function GetData(): array
	{
		return $this->aData;
	}

	/**
	 * @param array $aData
	 */
	public function SetData(array $aData): void
	{
		$this->aData = $aData;
	}

	/**
	 * @param string $sUrlForRefresh
	 */
	public function SetFilter($sFilter): void
	{
		$this->sFilter = $sFilter;
	}

	public function GetJSRefresh(): string
	{
		//$('#".$this->sId."').DataTable().clear().rows.add(data).draw()
		$aParams = [
			'style' => 'list',
			'filter' => $this->sFilter,
			'extra_params' => $this->aExtraParams,
		];

		return "$.post('".utils::GetAbsoluteUrlAppRoot()."pages/ajax.render.php?operation=refreshDashletList', ".json_encode($aParams).", 
					function (data) {
						$('#".$this->sId."').DataTable().clear();
	                    $('#".$this->sId."').dataTable().fnAddData(data);
					});";
	}
}