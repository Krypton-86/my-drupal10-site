<?php

namespace Drupal\movie_directory\Controller;

use Drupal\Core\Controller\ControllerBase;

class MovieListing extends ControllerBase {

  public function view () {
    $this->listMovies();
    $content = [];
    $content['movies'] = $this->createMovieCard();

    return [
      '#theme' => 'movie-listing',
      '#content' => $content,
    ];
  }

  public function listMovies() {
    /** @var \MovieAPIConnector $movie_api_connector_service */
    $movie_api_connector_service = \Drupal::service('movie_directory.api_connector');
    $movie_list = $movie_api_connector_service->discoverMovies();
    if (!empty($movie_list->results)) {
      return $movie_list->results;
    }
    return [];
  }

  public function  createMovieCard() {
    /** @var \Drupal\movie_directory\MovieAPIConnector $movie_api_connector_service */
    $movie_api_connector_service = \Drupal::service('movie_directory.api_connector');
    $movieCards = [];

    $movies = $this->listMovies();

    if (!empty($movies)) {
      foreach ($movies as $movie) {
        $content = [
          'title' => $movie->title,
          'description' => $movie->overview,
          'movie_id' => $movie->id,
          'image' => $movie_api_connector_service->getImageUrl($movie->poster_path)
        ];
        $movieCards[] = [
          '#theme' => 'movie-card',
          '#content' => $content
        ];
      }
    }
    return $movieCards;
  }
}
