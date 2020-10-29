<?php

/**
 * @file
 * Functions to support theming in the Adminimal theme.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\Attribute;
use Drupal\Core\File\FileSystemInterface;

function fluffster_form_system_theme_settings_alter(&$form, Drupal\Core\Form\FormStateInterface $form_state, $form_id = NULL)
{
  // Work-around for a core bug affecting admin themes. See issue #943212.
  if (isset($form_id)) {
    return;
  }

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
    '#type'             => 'managed_file',
    '#title'            => t('Image'),
    '#required'         => FALSE,
    '#upload_location'  => 'public://',
    '#description'      => t('Appears above URL of the Image'),
    '#default_value'    => theme_get_setting('fluffster_image'),
    '#upload_validators' => array(
      'file_validate_extensions' => array('gif png jpg jpeg'),
    ),
  );

  // First Banner Title
  $form['fluffster_first_banner'] = array(
    '#type'         => 'details',
    '#title'        => t('First Banner'),
    '#description'  => t('Configure info displayed on first banner'),
    '#weight'       => -10,
    '#open'         => TRUE,
  );

  $form['fluffster_first_banner']['fluffster_title'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Banner Title'),
    '#description'    => t("This text will be display on the first banner title."),
    '#default_value'  => theme_get_setting('fluffster_first_banner_title'),
  );

}

