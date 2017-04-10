<?php

namespace ForestPay\Events;

use ForestPay\Services\Validation\Note;

trait EnterNoteTrait
{
    /**
     * @param array $data
     * @return \Note|void
     * @throws \Exception - if unable to validate the transaction
     */
    public function createNote(array $data = [])
    {
        if (empty($data)) {
            return;
        }

        $noteValidator = new Note($data);

        if ($noteValidator->fails()) {
            throw new \Exception("Failed to validate log");
        }

        $note = new \Note($noteValidator->data());
        $note->save();
        return $note;
    }
}