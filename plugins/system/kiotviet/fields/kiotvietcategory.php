<?php
/**
 * @package     RedSHOP.Frontend
 * @subpackage  mod_redshop_categories
 *
 * @copyright   Copyright (C) 2008 - 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

// No direct access
defined('_JEXEC') or die;

JLoader::import('redshop.library');
JFormHelper::loadFieldClass('list');

/**
 * Class JFormFieldRedshopCategoryRemove
 *
 * @since  1.5
 */
class JFormFieldKiotvietcategory extends JFormFieldList
{
    /**
     * @access private
     */
    protected $name = 'kiotvietcategory';

    /**
     * Method to get the field input markup for a generic list.
     *
     * @return  string  The field input markup.
     */
    public function getInput()
    {
        $plugin = JPluginHelper::getPlugin('system', 'kiotviet');

        if (empty($plugin)) {
            return false;
        }

        $kiotviet = new Kiotviet\ConnectApi();
        $params   = json_decode($plugin->params);

        if (empty($params->client_id) || empty($params->secret_id) || empty($params->retailer)) {
            return false;
        }

        $config = array(
            'client_id' => $params->client_id,
            'secret_id' => $params->secret_id
        );
        $kiotviet->setConfig($config);

        $accessToken = $kiotviet->getAccessToken();
        $headers     = $kiotviet->getHeaders($accessToken, $params->retailer);

        $client = $kiotviet->getClient();

        $response = $client->request('GET', 'categories', $headers);

        try {
            $response = $client->request('GET', 'categories', $headers);
        } catch (Exception $e) {
            return false;
        }

        $categories = json_decode($response->getBody()->getContents())->data;

        $options   = array();

        if (!$this->element['multiple']) {
            $options[] = JHTML::_('select.option', '', JText::_('PLG_SYSTEM_KIOTVIET_SELECT_CATEGORIES'), 'value', 'text');
        }

        if (count($categories) > 0) {
            foreach ($categories as $category) {
                $option      = JHTML::_('select.option', $category->categoryId, $category->categoryName);
                $options[]   = $option;
            }
        }

        $options = array_merge(parent::getOptions(), $options);

        $attr = '';

        // Initialize some field attributes.
        $attr .= $this->element['class'] ? ' class="' . (string)$this->element['class'] . '"' : '';
        $attr .= $this->element['size'] ? ' size="' . (int)$this->element['size'] . '"' : '';
        $attr .= $this->element['multiple'] ? ' multiple' : '';

        // Initialize JavaScript field attributes.
        $attr .= $this->element['onchange'] ? ' onchange="' . (string)$this->element['onchange'] . '"' : '';

        return JHTML::_(
            'select.genericlist',
            $options,
            $this->name,
            trim($attr),
            'value',
            'text',
            $this->value,
            $this->id
        );
    }
}
