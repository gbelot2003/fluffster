<?php

/**
 * @file
 * Functions to support theming in the Adminimal theme.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;
use Drupal\Core\File\FileSystemInterface;
use Drupal\entity_settings\EntitySettings;
use Drupal\kint\Plugin\Devel\Dumper\Kint;
use Drupal\node\Entity\Node;

function fluffster_form_system_theme_settings_alter(&$form, FormStateInterface $form_state, $form_id = NULL)
{
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

  $node = theme_get_setting('first_node');
  $first_node = (int) $node[0]['target_id'];

  // Front main image info
  $form['fluffster_main_image'] = array(
    '#type'         => 'details',
    '#title'        => t('Main Image'),
    '#description'  => t('Configure displayed image in front Page'),
    '#weight'       => -10,
    '#open'         => TRUE,
  );

  $form['fluffster_main_image']['fluffster_block_title'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Images about Title'),
    '#description'    => t("This text will be display about the images with a description of your site."),
    '#default_value'  => theme_get_setting('fluffster_block_title'),
  );

  $form['fluffster_main_image']['fluffster_image'] = array(
    '#type'                      => 'managed_file',
    '#title'                     => t('Image'),
    '#required'                  => FALSE,
    '#upload_location'           => 'public://',
    '#description'               => t('Appears above URL of the Image'),
    '#default_value'             => theme_get_setting('fluffster_image'),
    '#upload_validators'         => array(
      'file_validate_extensions' => array('gif png jpg jpeg'),
    ),
  );

  // First Banner Title
  $form['fluffster_banners'] = array(
    '#type'         => 'details',
    '#title'        => t('First Text Banner'),
    '#description'  => t('Configure info displayed on first banner'),
    '#weight'       => -10,
    '#open'         => TRUE,
  );

  $form['fluffster_banners']['fluffster_first_title'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Banner Title'),
    '#description'    => t("This text will be display on the first banner title."),
    '#default_value'  => theme_get_setting('fluffster_first_title'),
  );

  $form['fluffster_banners']['fluffster_first_subtext'] = array(
    '#type'           => 'search',
    '#title'          => t('Banner sub-text'),
    '#description'    => t("This text will be display on the first banner subtext."),
    '#default_value'  => theme_get_setting('fluffster_first_subtext'),
  );

  $form['fluffster_banners']['first_node'] = array(
    '#type'                 => 'entity_autocomplete',
    '#title'                => t('Banner sub-text'),
    '#target_type'          => 'node',
    '#tags'                 => TRUE,
    '#default_value'        => Node::load($first_node),
    '#selection_handler'    => 'default',
    '#selection_settings'   => array(
      'target_bundles'      => ['article', 'page'],
    ),
    '#autocreate'           => array(
      'bundle'              => 'article',
      'uid'                 => 1,
      )
    );

}

