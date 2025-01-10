<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Task Manager API Documentation",
 *      description="API para gerenciar tarefas de uma equipe"
 * )
 *
 * @OA\Tag(
 *     name="Tasks",
 *     description="Endpoints relacionados às tarefas"
 * )
 */
class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Listar todas as tarefas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tarefas retornada com sucesso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Minha primeira tarefa"),
     *                 @OA\Property(property="description", type="string", example="Descrição da tarefa"),
     *                 @OA\Property(property="due_date", type="string", format="date", example="2025-01-15"),
     *                 @OA\Property(property="status", type="string", example="pending"),
     *                 @OA\Property(property="user_id", type="integer", nullable=true, example=null)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Task::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     tags={"Tasks"},
     *     summary="Criar uma nova tarefa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="due_date", type="string", format="date"),
     *             @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}),
     *             @OA\Property(property="user_id", type="integer", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tarefa criada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Minha primeira tarefa"),
     *             @OA\Property(property="description", type="string", example="Descrição da tarefa"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2025-01-15"),
     *             @OA\Property(property="status", type="string", example="pending"),
     *             @OA\Property(property="user_id", type="integer", nullable=true, example=null)
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Exibir uma tarefa específica",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da tarefa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da tarefa retornados com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Minha primeira tarefa"),
     *             @OA\Property(property="description", type="string", example="Descrição da tarefa"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2025-01-15"),
     *             @OA\Property(property="status", type="string", example="pending"),
     *             @OA\Property(property="user_id", type="integer", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada"
     *     )
     * )
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Atualizar uma tarefa existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da tarefa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="due_date", type="string", format="date"),
     *             @OA\Property(property="status", type="string", enum={"pending", "in_progress", "completed"}),
     *             @OA\Property(property="user_id", type="integer", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa atualizada com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Minha primeira tarefa (Atualizada)"),
     *             @OA\Property(property="description", type="string", example="Descrição da tarefa (Atualizada)"),
     *             @OA\Property(property="due_date", type="string", format="date", example="2025-02-01"),
     *             @OA\Property(property="status", type="string", example="in_progress"),
     *             @OA\Property(property="user_id", type="integer", nullable=true, example=null)
     *         )
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'string',
            'due_date' => 'date',
            'status' => 'in:pending,in_progress,completed',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);

        return response()->json($task, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Deletar uma tarefa existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID da tarefa",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Tarefa deletada com sucesso"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return response()->json(null, 204);
    }
}
