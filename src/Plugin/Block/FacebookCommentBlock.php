<?php
/**
 * @file
 * Contains Drupal\facebook_comment\Plugin\Block\FacebookCommentBlock.
 */
namespace Drupal\facebook_comment\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Facebook Comment Block.
 * @Block(
 *  id = "facebook_comment_block",
 *  admin_label = @Translation("Facebook Comment Block")
 * )
 */
class FacebookCommentBlock extends BlockBase implements BlockPluginInterface {

  /**
  * {@inheritdoc}
  */
  public function build() {
    $build = [];
    $request = \Drupal::request();
    $config = $this->getConfiguration();
    $build[] = [
      "#theme" => "facebook_comment",
      "#pageUrl" => $request->getUri(),
      "#applicationCode" => isset($config['fc_applicationCode']) ? $config['fc_applicationCode'] : "",
      "#numPosts" => isset($config['fc_numPosts']) ? $config['fc_numPosts'] : "10",
      "#width" => isset($config['fc_width']) ? $config['fc_width'] : "100%",
      "#orderBy" => isset($config['fc_orderBy']) ? $config['fc_orderBy'] : "social",
      "#colorScheme" => isset($config['fc_colorScheme']) ? $config['fc_colorScheme'] : "light",
      "#attached" => [
        'library' => [
          "facebook_comment/fb-comment",
          ],
        ],
    ];
    return $build;
  }

  /**
  * {@inheritdoc}
  */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['fc_applicationCode'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Aplication Code"),
      '#description' => $this->t("Facebook App-id. If you do not know this see module information."),
      '#default_value' => isset($config['fc_applicationCode']) ? $config['fc_applicationCode'] : "",
      '#required' => TRUE,
    );
    $form['fc_numPosts'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Number comment display"),
      '#description' => $this->t("Number of comment display per page"),
      '#default_value' => isset($config['fc_numPosts']) ? $config['fc_numPosts'] : "10",
    );
    $form['fc_width'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Width size"),
      '#description' => $this->t("Maximum size for display on the page, if the size is in percent must include the symbol ( % )."),
      '#default_value' => isset($config['fc_width']) ? $config['fc_width'] : "100%",
    );
    $form['fc_orderBy'] = array(
      '#type' => 'radios',
      '#title' => $this->t("Order By"),
      '#options' => [
        'social' => $this->t('Social'),
        'reverse_time' => $this->t('Desc'),
        'time' => $this->t('Asc'),
      ],
      '#description' => $this->t("Select an order to display Comments."),
      '#default_value' => isset($config['fc_orderBy']) ? $config['fc_orderBy'] : "social",
    );
    $form['fc_colorScheme'] = array(
      '#type' => 'radios',
      '#title' => $this->t("Color Schema"),
      '#options' => [
        'light' => $this->t('Light'),
        'dark' => $this->t('Dark'),
      ],
      '#description' => $this->t("Select a theme for display comment block."),
      '#default_value' => isset($config['fc_colorScheme']) ? $config['fc_colorScheme'] : "light",
    );
    return $form;
  }

  /**
  * {@inheritdoc}
  */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('fc_applicationCode', $form_state->getValue('fc_applicationCode'));
    $this->setConfigurationValue('fc_numPosts', $form_state->getValue('fc_numPosts'));
    $this->setConfigurationValue('fc_width', $form_state->getValue('fc_width'));
    $this->setConfigurationValue('fc_orderBy', $form_state->getValue('fc_orderBy'));
    $this->setConfigurationValue('fc_colorScheme', $form_state->getValue('fc_colorScheme'));
  }

}
