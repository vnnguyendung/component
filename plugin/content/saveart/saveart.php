<?php
/**
 * @copyright	Copyright (c) 2017 saveart. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * content - saveart Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	saveart.saveart
 */
class plgcontentsaveart extends JPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
	}
	
	public function onContentAfterDisplay($context, &$row, &$params, $page = 0)
	{
		//dump($row,'BIEN');
		$html = '';			
	
		//$html .= $formx->renderField('art_id');
		
		/////////////////////////////////////////////////////////
		JForm::addFormPath(JPATH_SITE. '/components/com_save/models/forms');
		JForm::addFieldPath(JPATH_SITE. '/components/com_save/models/fields');		
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_save/models', 'SaveModel');
		$model = JModelLegacy::getInstance('SavenameinternalForm', 'SaveModel', array('ignore_request' => true));
		
		// check xem co trong data base hay ko.
		
		
		$this->id_artid = $row->id; 
		$this->id_user= JFactory::getUser()->get('id');
		
		$id_artid = $this->id_artid; 
		$id_user = $this->id_user;
		$coketqua = $this->checktontai($id_artid, $id_user);
		
		
		
		
		//$model->setState('art_id', 2223 );
		$model->setState('savenameinternal.id', $coketqua);
		$this->form = $model->getForm();
		//dump($layform, 'LAY FORM');
		// return array, empty
		//var_dump($layform->getData());
		//dump($layform->getData(), 'BIEN ITEMS');
		
		//$html .= $layform->renderField('art_id');
		
		
		if (!is_null($coketqua)){
			$html .= '<button class="btn btn-primary btn-lg">Da SAVE</button>';
			$linkdel = 'index.php?option=com_save&task=savenameinternal.remove&id=' . $coketqua; 
			$html .= '<a href="'. $linkdel .'" class="btn btn-danger">DEL</a>';
			
		} else {		
				$path = JPluginHelper::getLayoutPath('content', 'saveart');	
				ob_start();
				include $path;
				$html .= ob_get_clean();
		}
		
		return $html;
		
		// return $this->displayVotingData($context, $row, $params, $page);
	}
	
	protected function checktontai($art,$user){
		// Create a new query object.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$query->select('a.id');	
		
		$query->from('`#__save_` AS a');
		$query->where('a.art_id =' . $art);
		$query->where('created_by =' . $user);
		
		$db->setQuery($query);
		return $db->loadResult();
		
	}
	
	
}