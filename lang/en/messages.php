<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Custom English Messages
    |--------------------------------------------------------------------------
    */
    'invalid_id'                      => 'Invalid ID',
    'can_not_cancel_vacation_request' => 'Vacation Request can only be canceled while it is still in the Proposal status',
    'vacation_cancel'                 => 'Vacation request cancelled successfully',
    'not_valid_cutting_at'            => [
        'normal' => 'The cutting date must be between vacation date',
        'cut'    => 'The cutting date must be before the previous cutting date',
    ],
    'vacation_not_accepted'           => 'This vacation is not accepted',
    'no_approval_levels'              => 'This vacation has no approval levels. Please create one',
    'already_take_action'             => 'This action is already taken',
    'vacation_already_extend'         => 'There is already a pending vacation extension request',
    'has_days'                        => 'No more days left',
    'has_series_days'                 => 'The number of consecutive days allowed has been exceeded',
    'can_not_cutting_vacation'        => 'This vacation cannot be cutting before it can accepted',
    'not_percent_value'               => 'The value must be percentage',
    'penalty_value_percentage'        => 'Value field must be between 1,100',
    'unique_error'                    => "You can't react again",
    'report_creation_failed'          => "Unable to find the salary for the specified month",
    'no_token'                        => 'There is no Token',
    'cant_update_vacation_request'    => 'Vacation requests can only be edited while they are in the proposal state',
    'invalid_update_vacation_request' => "Unable to update the vacation request: the provided data exceeds the limit for this vacation type",
    'hourly_vacation_only'            => "This route isn't suitable for a regular vacation; it's made for hourly vacations.",
    'stopped_vacation'                => "You can't cut a vacation when it's already stopped.",
    'cutting_vacation'                => 'This Vacation Is Interrupted',
    'already_has_passport'            => 'This employee already has a passport',


];
