<?php

namespace Drupal\cat_of_the_day\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for handling cat voting via AJAX.
 */
class CatVotingController extends ControllerBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a new CatVotingController.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Handles the AJAX voting.
   */
  public function vote(Request $request) {
    $cat_image = $request->query->get('cat_image');
    $vote_type = $request->query->get('vote_type');

    // Fetch the current vote count from the database.
    $record = $this->database->select('cat_votes', 'cv')
      ->fields('cv', ['id', 'votes_up', 'votes_down'])
      ->condition('cat_image', $cat_image)
      ->execute()
      ->fetchAssoc();

    if ($record) {
      // Update the vote count.
      if ($vote_type === 'up') {
        $this->database->update('cat_votes')
          ->fields(['votes_up' => $record['votes_up'] + 1])
          ->condition('id', $record['id'])
          ->execute();
      }
      elseif ($vote_type === 'down') {
        $this->database->update('cat_votes')
          ->fields(['votes_down' => $record['votes_down'] + 1])
          ->condition('id', $record['id'])
          ->execute();
      }
    }
    else {
      // Insert a new vote record if this is the first time the cat image is voted on.
      $this->database->insert('cat_votes')
        ->fields([
          'cat_image' => $cat_image,
          'votes_up' => ($vote_type === 'up') ? 1 : 0,
          'votes_down' => ($vote_type === 'down') ? 1 : 0,
        ])
        ->execute();
    }

    // Fetch updated vote counts.
    $updated_record = $this->database->select('cat_votes', 'cv')
      ->fields('cv', ['votes_up', 'votes_down'])
      ->condition('cat_image', $cat_image)
      ->execute()
      ->fetchAssoc();

    // Return the updated vote counts in a JSON response.
    return new JsonResponse([
      'votes_up' => $updated_record['votes_up'],
      'votes_down' => $updated_record['votes_down'],
    ]);
  }

}
