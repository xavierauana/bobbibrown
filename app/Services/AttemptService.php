<?php
/**
 * Author: Xavier Au
 * Date: 22/9/2017
 * Time: 8:32 PM
 */

namespace App\Services;


use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use Anacreation\Etvtest\Services\GradingService;
use App\User;

class AttemptService
{

    public function createAttemptData(GradingService $gradingService, Test $test
    ): array {
        $attempt_data = [
            "test_id" => $test->id,
            "attempt" => $gradingService->result,
            "score"   => $gradingService->summary['correct'] / count($gradingService->result),
        ];

        return $attempt_data;
    }

    public function createUserAttemptRecord(
        Test $test, GradingService $service, User $user = null
    ): Attempt {

        $attempt_data = [];

        if ($user) {
            $attempt_data = $this->createAttemptData($service, $test);

            /** @var Attempt $attempt */
            $attempt = $user->attempts()->create($attempt_data);

            return $attempt;
        }

        return new Attempt($attempt_data);
    }
}