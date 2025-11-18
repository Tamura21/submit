<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_owner_cannot_edit_update_or_delete_task()
    {
        // 1. 所有者 userA と別ユーザー userB を作成
        $owner = User::factory()->create();
        $other = User::factory()->create();

        // 2. owner が作ったタスクを用意
        $task = Task::factory()->create(['user_id' => $owner->id]);

        // 3. other でログインして edit ページへ行く -> 403
        $this->actingAs($other)
             ->get(route('tasks.edit', $task))
             ->assertStatus(403);

        // 4. 更新を試みる -> 403
        $this->actingAs($other)
             ->put(route('tasks.update', $task), [
                 'title' => '不正な更新',
                 'task_status' => 1,
             ])->assertStatus(403);

        // 5. 削除を試みる -> 403
        $this->actingAs($other)
             ->delete(route('tasks.destroy', $task))
             ->assertStatus(403);
    }

    public function test_owner_can_edit_update_and_delete()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
             ->get(route('tasks.edit', $task))
             ->assertStatus(200);

        $this->actingAs($user)
             ->put(route('tasks.update', $task), [
                 'title' => '更新成功',
                 'task_status' => 1,
             ])->assertRedirect(route('tasks.index'));

        $this->actingAs($user)
             ->delete(route('tasks.destroy', $task))
             ->assertRedirect(route('tasks.index'));
    }
}
