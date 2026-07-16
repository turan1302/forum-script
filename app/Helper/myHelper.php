<?php

namespace App\Helper;

use App\Models\NotificationModel;
use App\Models\QuestionCategoryModel;
use App\Models\QuestionsModel;

class myHelper
{
    /**
     * @param string $type
     * @param string $userId
     * @param string $receiverId
     * @param string $text
     */
    public static function notification($type, $userId, $receiverId, $text)
    {
        // BILDIRIM SISTEMI AYARLANDI
        NotificationModel::create(array(
            "type" => $type,
            "userId" => $userId,
            "receiverUserId" => $receiverId,
            "text" => $text
        ));
    }

    // KATEGORI GETIRME ISLEMINI AYARLATALIM
    public static function soruYorumSayi($soruId)
    {
        $soru = QuestionsModel::leftJoin("comments", "comments.question_id", "=", "questions.id")
            ->where(array(
                "comments.question_id" => $soruId,
                "comments.status" => 1
            ))->count();

        return $soru;
    }
}
