<?php

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('online', function (User $user) {
    return $user ? new UserResource($user) : null; //for authenthication user
});

Broadcast::channel('message.user.{userId1}-{userId2}', function(User $user, int $userId1, int $userId2){
    return $user->id === $userId1 || $user->id === $userId2 ? $user : null;
});

Broadcast::channel('message.group.{groupId}', function(User $user, int $groupId){
    return $user->groups->contains('id', $groupId) ? $user : null;
});