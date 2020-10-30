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

  $node2 = theme_get_setting('secund_node');
  $secund_node = (int) $node2[0]['target_id'];

  $node3 = theme_get_setting('third_node');
  $third_node = (int) $node3[0]['target_id'];

  $slink1 = theme_get_setting('service_link');
  $service_link = (int) $slink1[0]['target_id'];

  $cpsLink = theme_get_setting('fluffster_colored_link');
  $coloredLink = (int) $cpsLink[0]['target_id'];


  // Front main image info
  $form['fluffster_main_image'] = array(
    '#type'         => 'details',
    '#title'        => t('Main Block Image'),
    '#description'  => t('Configure displayed image and text in first panel'),
    '#weight'       => -10,
    '#open'         => FALSE,
  );

  $form['fluffster_main_image']['fluffster_block_title'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Main Text'),
    '#description'    => t("Text over image, if not set the site name will be display"),
    '#default_value'  => theme_get_setting('fluffster_block_title'),
  );

  $form['fluffster_main_image']['fluffster_image'] = array(
    '#type'                      => 'managed_file',
    '#title'                     => t('Front Image'),
    '#required'                  => FALSE,
    '#upload_location'           => 'public://',
    '#description'               => t('Main images of the front page'),
    '#default_value'             => theme_get_setting('fluffster_image'),
    '#upload_validators'         => array(
      'file_validate_extensions' => array('gif png jpg jpeg'),
    ),
  );

  // First Banner Title
  $form['fluffster_banners'] = array(
    '#type'         => 'details',
    '#title'        => t('First Panels Section'),
    '#description'  => t('Configure info displayed on first set of panels'),
    '#weight'       => -10,
    '#open'         => FALSE,
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
    '#title'                => t('Services First Panel'),
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

  $form['fluffster_banners']['secund_node'] = array(
    '#type'                 => 'entity_autocomplete',
    '#title'                => t('Services Secund Panel'),
    '#target_type'          => 'node',
    '#tags'                 => TRUE,
    '#default_value'        => Node::load($secund_node),
    '#selection_handler'    => 'default',
    '#selection_settings'   => array(
      'target_bundles'      => ['article', 'page'],
    ),
    '#autocreate'           => array(
      'bundle'              => 'article',
      'uid'                 => 1,
    )
  );

  $form['fluffster_banners']['third_node'] = array(
    '#type'                 => 'entity_autocomplete',
    '#title'                => t('Services Third Panel'),
    '#target_type'          => 'node',
    '#tags'                 => TRUE,
    '#default_value'        => Node::load($third_node),
    '#selection_handler'    => 'default',
    '#selection_settings'   => array(
      'target_bundles'      => ['article', 'page'],
    ),
      '#autocreate'           => array(
      'bundle'              => 'article',
      'uid'                 => 1,
    )
  );

  $form['fluffster_banners']['service_link'] = array(
    '#type'                 => 'entity_autocomplete',
    '#title'                => t('Services Link'),
    '#target_type'          => 'node',
    '#tags'                 => TRUE,
    '#description'          => t("A small link to services page under first panels"),
    '#default_value'        => Node::load($service_link),
    '#selection_handler'    => 'default',
    '#selection_settings'   => array(
    'target_bundles'      => ['article', 'page'],
    ),
      '#autocreate'           => array(
      'bundle'              => 'article',
      'uid'                 => 1,
    )
  );

  // Colored Secundary panel
  $form['fluffster_colored_panel'] = array(
    '#type'         => 'details',
    '#title'        => t('Colored Secundary Section'),
    '#description'  => t('Configure info displayed on colored secundary panel'),
    '#weight'       => -10,
    '#open'         => FALSE,
  );

  $form['fluffster_colored_panel']['fluffster_colored_text'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Colored Panel Text'),
    '#description'    => t("This text will be display as text on the secunday panel."),
    '#default_value'  => theme_get_setting('fluffster_colored_text'),
  );

  $form['fluffster_colored_panel']['fluffster_colored_link'] = array(
    '#type'                 => 'entity_autocomplete',
    '#title'                => t('Colored Panel Link'),
    '#target_type'          => 'node',
    '#tags'                 => TRUE,
    '#description'          => t("A small link to a page under Colored Panels"),
    '#default_value'        => Node::load($coloredLink),
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

