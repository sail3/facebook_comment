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
    dpm($request->getUri());
    // $build['facebook_comment']['#markup'] = "facebook.com";
    $build[] = [
      "#theme" => "facebook_comment",
      "#description" => "foo",
      "#appId" => $config['fc_app_id'],
      "#appUrl" => "hola mundo",

      "#applicationCode" => $config['fc_applicationCode'],
      "#pageUrl" => $config['fc_pageUrl'],
      "#pageUrl" => $request->getUri(),
      "#numPosts" => $config['fc_numPosts'],
      "#width" => $config['fc_width'],
      "#orderBy" => $config['fc_orderBy'],
      "#colorScheme" => $config['fc_colorScheme'],

      "#attributes" => [],
      "#attached" => [
        'library' => [
          "facebook_comment/fb-comment",
          ],
        ],
    ];
    return $build;
  }
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['fc_app_id'] = array(
     '#type' => 'textfield',
     '#title' => $this->t("App Id"),
     '#description' => $this->t("Insert a app id from facebook."),
     '#default_value' => isset($config['fc_app_id']) ? $config['fc_app_id'] : "",
    );
    $form['fc_applicationCode'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Aplication Code"),
      '#description' => $this->t("Dumi description"),
      '#default_value' => isset($config['fc_applicationCode']) ? $config['fc_applicationCode'] : "",
    );
    $form['fc_pageUrl'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("dummi text"),
      '#description' => $this->t("Dumi description"),
      '#default_value' => isset($config['fc_pageUrl']) ? $config['fc_pageUrl'] : "",
    );
    $form['fc_numPosts'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Number post display"),
      '#description' => $this->t("Dumi description"),
      '#default_value' => isset($config['fc_numPosts']) ? $config['fc_numPosts'] : "10",
    );
    $form['fc_width'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Width size"),
      '#description' => $this->t("Dumi description"),
      '#default_value' => isset($config['fc_width']) ? $config['fc_width'] : "100%",
    );
    $form['fc_orderBy'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Order By"),
      '#description' => $this->t("Dumi description"),
      '#default_value' => isset($config['fc_orderBy']) ? $config['fc_orderBy'] : "social",
    );
    $form['fc_colorScheme'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Color Schema"),
      '#description' => $this->t("Dumi description"),
      '#default_value' => isset($config['fc_colorScheme']) ? $config['fc_colorScheme'] : "light",
    );
    return $form;
  }
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $this->setConfigurationValue('fc_app_id', $form_state->getValue('fc_app_id'));

    $this->setConfigurationValue('fc_applicationCode', $form_state->getValue('fc_applicationCode'));
    $this->setConfigurationValue('fc_pageUrl', $form_state->getValue('fc_pageUrl'));
    $this->setConfigurationValue('fc_numPosts', $form_state->getValue('fc_numPosts'));
    $this->setConfigurationValue('fc_width', $form_state->getValue('fc_width'));
    $this->setConfigurationValue('fc_orderBy', $form_state->getValue('fc_orderBy'));
    $this->setConfigurationValue('fc_colorScheme', $form_state->getValue('fc_colorScheme'));
  }

}
