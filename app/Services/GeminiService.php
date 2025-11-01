<?php

namespace App\Services;

use Gemini\Data\Schema;
use Gemini\Enums\DataType;
use Gemini\Enums\ResponseMimeType;
use Gemini\Laravel\Facades\Gemini;

class GeminiService
{
    public function checkMaterial($title, $content)
    {
        $prompt = "Periksa kesesuaian materi ini dengan judul: $title\n\nKonten: $content";

        try {
            $result = Gemini::generativeModel('gemini-2.0-flash-exp')
                ->withGenerationConfig(
                    generationConfig: Gemini::generationConfig(
                        responseMimeType: ResponseMimeType::APPLICATION_JSON,
                        responseSchema: new Schema(
                            type: DataType::OBJECT,
                            properties: [
                                'relevant' => new Schema(type: DataType::BOOLEAN),
                                'reason' => new Schema(type: DataType::STRING)
                            ],
                            required: ['relevant']
                        )
                    )
                )->generateContent($prompt);

            $response = json_decode($result->text(), true);
            return $response['relevant'] ?? false;

        } catch (\Exception $e) {
            return false;
        }
    }
}
