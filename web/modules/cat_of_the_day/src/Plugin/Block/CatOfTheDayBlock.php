<?php

namespace Drupal\cat_of_the_day\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Cat of the Day' Block.
 *
 * @Block(
 *   id = "cat_of_the_day_block",
 *   admin_label = @Translation("Cat of the Day"),
 * )
 */
class CatOfTheDayBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get the random cat image.
    $cat_image_url = $this->getRandomCatImage();

    // Return the block content.
    return [
      '#theme' => 'cat_of_the_day',
      '#cat_image' => $cat_image_url,
      '#attached' => [
        'library' => ['cat_of_the_day/cat_of_the_day']
      ]
    ];
  }

  /**
   * Fetch a random cat image from The Cat API.
   */
  protected function getRandomCatImage() {
    try {
      $client = \Drupal::httpClient();
      $response = $client->get('https://api.thecatapi.com/v1/images/search');
      $data = json_decode($response->getBody()->getContents(), TRUE);
      return $data[0]['url'] ?? '';
    }
    catch (\Exception $e) {
      \Drupal::logger('cat_of_the_day')->error($e->getMessage());
      return '';
    }
  }

}
