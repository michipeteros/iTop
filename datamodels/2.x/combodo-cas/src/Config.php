<?php
/**
 * @copyright   Copyright (C) 2010-2019 Combodo SARL
 * @license     https://www.combodo.com/documentation/combodo-software-license.html
 *
 */

namespace Combodo\iTop\Cas;

use MetaModel;

class Config
{
	/**
	 * Get modules settings and general settings as a fallback
	 * This is done to allow compatibility with previous versions where
	 * CAS was configured in the general settings
	 *
	 * @param $sName
	 *
	 * @return mixed
	 */
	public static function Get($sName)
	{
		$sValue = MetaModel::GetModuleSetting('combodo-cas', $sName, '');
		if (empty($sValue))
		{
			$sValue = MetaModel::GetConfig()->Get($sName);
		}

		return $sValue;
	}
}