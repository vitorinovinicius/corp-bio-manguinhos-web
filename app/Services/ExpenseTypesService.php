<?php

namespace App\Services;

use App\Criteria\ExpenseTypesCriteria;
use App\Repositories\ExpenseTypesRepository;

class ExpenseTypesService
{
    private $expenseTypesRepository;

    public function __construct(ExpenseTypesRepository $expenseTypesRepository)
    {
        $this->expenseTypesRepository = $expenseTypesRepository;
    }

    public function listExpenseTypes()
    {
        $expenseTypes = $this->expenseTypesRepository->pushCriteria(new ExpenseTypesCriteria())->all();
        return view('expense_types.index', compact('expenseTypes'));
    }

    public function showExpenseTypes($expenseType)
    {
        return view('expense_types.show', compact('expenseType'));
    }

    public function createExpenseTypes()
    {
        if(!\Auth::user()->contractor_id) {
            return redirect()->route('expense_types.index')->with('error', "Apenas empresas podem cadastrar.");
        }

        return view('expense_types.create');
    }

    public function storeExpenseTypes($request)
    {
        if(!\Auth::user()->contractor_id) {
            return redirect()->route('expense_types.index')->with('error', "Apenas empresas podem cadastrar.");
        }

        $data = $request->all();

        try{
            $this->expenseTypesRepository->create($data);
            return redirect()->route('expense_types.index')->with('message', 'Item criado com sucesso.');
        }catch(\Exception $e){
            return redirect()->route('expense_types.index')->with('error', 'Erro ao criar o item.' . $e->getMessage());
        }

        return redirect()->route('expense_types.index')->with('error', 'Erro ao criar o item.');
    }

    public function editExpenseType($expenseType)
    {
        return view('expense_types.edit', compact('expenseType'));
    }

    public function updateExpenseType($request, $expenseType)
    {
        $data = $request->all();

        try{
            $this->expenseTypesRepository->update($data, $expenseType->id) ;
            return redirect()->route('expense_types.index')->with('message', 'Item atualizado com sucesso.');
        }catch(\Exception $e){
            return redirect()->route('expense_types.index')->with('error', 'Erro ao atualizar o item.' . $e->getMessage());
        }

        return redirect()->route('expense_types.index')->with('error', 'Erro ao atualizar o item.');
    }

    public function destroyExpenseType($expenseType)
    {
        try{
            $this->expenseTypesRepository->delete($expenseType->id) ;
            return redirect()->route('expense_types.index')->with('message', 'Item excluido com sucesso.');
        }catch(\Exception $e){
            return redirect()->route('expense_types.index')->with('error', 'Erro ao excluir o item.' . $e->getMessage());
        }

        return redirect()->route('expense_types.index')->with('error', 'Erro ao excluir o item.');
    }
}
