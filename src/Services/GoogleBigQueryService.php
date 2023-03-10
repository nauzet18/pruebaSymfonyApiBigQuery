<?php
namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Google\Cloud\BigQuery\BigQueryClient;
use App\Interfaces\BigQueryServiceInterface;
use App\Models\Params;

class GoogleBigQueryService implements BigQueryServiceInterface
{
    private BigQueryClient $bigQueryClient;
    private string $query;

    public function __construct(ContainerBagInterface $params)
    {
        $this->params = $params;

        $projectRoot = $this->params->get('kernel.project_dir');
        $file = $this->params->get('app.google_credentials_file_name');
        $projectId = $this->params->get('app.google_bigquery_project_id');

        putenv("GOOGLE_APPLICATION_CREDENTIALS=$projectRoot/$file");

        $this->bigQueryClient = new BigQueryClient([
            'projectId' => $projectId,
        ]);
    }

    public function getPostList(Params $params): array
    {
        $numLimit = $params->get('limit', 10);
        $keyOrder = $params->get('order', 'id');
        $directionOrder = $params->get('direction', 'DESC');

        $query = <<<ENDSQL
        SELECT *
        FROM `bigquery-public-data.stackoverflow.posts_questions`
        ORDER BY $keyOrder $directionOrder
        LIMIT $numLimit;
        ENDSQL;
        $this->setQuery($query);

        return $this->getResults();
    }

    public function getPost(Params $params, int $id): array
    {
        $query = <<<ENDSQL
        SELECT *
        FROM `bigquery-public-data.stackoverflow.posts_questions`
        WHERE id = $id
        ;
        ENDSQL;

        $this->setQuery($query);

        return $this->getResults();
    }

    public function getPostComents(Params $params, int $postId): array
    {
        $numLimit = $params->get('limit', 10);
        $keyOrder = $params->get('order', 'id');
        $directionOrder = $params->get('direction', 'DESC');

        $query = <<<ENDSQL
        SELECT *
        FROM `bigquery-public-data.stackoverflow.comments`
        WHERE post_id = $postId
        ORDER BY $keyOrder $directionOrder
        LIMIT $numLimit;
        ENDSQL;

        $this->setQuery($query);

        return $this->getResults();
    }

    private function setQuery(string $query): void
    {
        $this->query = $query;
    }

    private function getResults(): array
    {
        $queryJobConfig = $this->bigQueryClient->query($this->query);
        $queryResults = $this->bigQueryClient->runQuery($queryJobConfig);

        $data = [];
        if ($queryResults->isComplete()) {
            $i = 0;
            $rows = $queryResults->rows();


            foreach ($rows as $row) {
                $data[] = $row;
            }

        } else {
            throw new Exception('The query failed to complete');
        }

        return $data;
    }

}
