<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | WalletApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
    </style>
</head>
<body class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col">
        <div class="p-6">
            <div class="flex items-center gap-2 text-[#5D3FD3] font-bold text-xl">
                <i data-lucide="wallet"></i> <span>WalletApp</span>
            </div>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="#" class="flex items-center gap-3 bg-violet-50 text-[#5D3FD3] px-4 py-3 rounded-xl font-medium">
                <i data-lucide="layout-dashboard"></i> Dashboard
            </a>
            <a href="#" onclick="openBudgetModal()" class="flex items-center gap-3 text-slate-500 hover:bg-slate-50 px-4 py-3 rounded-xl transition">
                <i data-lucide="settings"></i> Setup Budget
            </a>
        </nav>
        <div class="p-6 border-t border-slate-100">
            <a href="/logout" class="flex items-center gap-3 text-red-500 font-medium">
                <i data-lucide="log-out"></i> Logout
            </a>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto p-8">
        <header class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Welcome, <?php echo $_SESSION['user_name'] ?? 'User'; ?>!</h1>
                <p class="text-slate-500">January 2026</p>
            </div>
            <button onclick="openBudgetModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-2.5 rounded-full font-semibold transition flex items-center gap-2">
                <i data-lucide="settings" class="w-5 h-5"></i> <?php echo ($status === 'old') ? 'Modify Budget' : 'Setup Budget'; ?>
            </button>
            <button onclick="openExpenseModal()" class="bg-[#5D3FD3] hover:bg-[#4B32B3] text-white px-6 py-2.5 rounded-full font-semibold transition flex items-center gap-2 shadow-lg shadow-violet-200">
                <i data-lucide="plus" class="w-5 h-5"></i> Add Expense
            </button>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-slate-500 text-sm font-medium mb-1">Total Budget</p>
                <h2 class="text-3xl font-bold text-slate-800">$<?php echo number_format($budget, 2); ?></h2>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-slate-500 text-sm font-medium mb-1">Total Expenses</p>
                <h2 class="text-3xl font-bold text-slate-800">$<?php echo number_format($totalExpenses, 2); ?></h2>
            </div>
            <div class="bg-emerald-500 p-6 rounded-3xl text-white shadow-lg">
                <p class="text-emerald-100 text-sm font-medium mb-1">Remaining Balance</p>
                <h2 class="text-3xl font-bold">$<?php echo number_format($balance, 2); ?></h2>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
            <h3 class="font-bold text-slate-800 text-lg mb-4">Recent Transactions</h3>
            <?php if (!empty($transactions)): ?>
                <div class="space-y-3">
                    <?php foreach (array_slice($transactions, 0, 5) as $transaction): ?>
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                            <div>
                                <p class="font-medium text-slate-700"><?php echo htmlspecialchars($transaction['titre']); ?></p>
                                <p class="text-sm text-slate-500"><?php echo ucfirst($transaction['category']); ?> • <?php echo date('M j, Y', strtotime($transaction['created_at'])); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-slate-800">-$<?php echo number_format($transaction['depense'], 2); ?></p>
                                <?php if ($transaction['type'] === 'autodepense'): ?>
                                    <span class="text-xs bg-violet-100 text-violet-600 px-2 py-1 rounded-full">Auto</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-slate-500 text-center py-8">No transactions yet. Add your first expense!</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Budget Setup Modal -->
    <div id="budgetModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-900"><?php echo ($status === 'old') ? 'Modify Your Budget' : 'Setup Your Budget'; ?></h2>
                    <button onclick="closeBudgetModal()" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <form action="/setup-budget" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Monthly Budget</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                            </span>
                            <input type="number" name="budget" step="0.01" min="0" placeholder="5000.00" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-slate-700 mb-4">Automatic Monthly Expenses (Optional)</h3>
                        <div id="autoExpenses" class="space-y-4">
                            <div class="expense-item grid grid-cols-1 md:grid-cols-4 gap-4 p-4 bg-slate-50 rounded-2xl">
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Expense Name</label>
                                    <input type="text" name="auto_expenses[0][name]" placeholder="Rent, Netflix, etc."
                                        class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5D3FD3]/20 focus:border-[#5D3FD3]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Category</label>
                                    <select name="auto_expenses[0][category]" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5D3FD3]/20 focus:border-[#5D3FD3]">
                                        <option value="rent">Rent</option>
                                        <option value="food">Food</option>
                                        <option value="transport">Transport</option>
                                        <option value="utilities">Utilities</option>
                                        <option value="entertainment">Entertainment</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Amount</label>
                                    <input type="number" name="auto_expenses[0][amount]" step="0.01" min="0" placeholder="0.00"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5D3FD3]/20 focus:border-[#5D3FD3]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-600 mb-1">Day of Month</label>
                                    <input type="number" name="auto_expenses[0][day]" min="1" max="31" placeholder="1"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5D3FD3]/20 focus:border-[#5D3FD3]">
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" onclick="addExpense()" class="mt-4 flex items-center gap-2 text-[#5D3FD3] font-semibold hover:text-[#4B32B3]">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Add Another Expense
                        </button>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" onclick="closeBudgetModal()" class="flex-1 px-6 py-3 rounded-2xl bg-slate-100 font-semibold text-slate-600 hover:bg-slate-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-6 py-3 rounded-2xl bg-[#5D3FD3] text-white font-semibold hover:bg-[#4B32B3] transition">
                            <?php echo ($status === 'old') ? 'Update Budget' : 'Setup Budget'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Expense Modal -->
    <div id="expenseModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-900">Add Expense</h2>
                    <button onclick="closeExpenseModal()" class="text-slate-400 hover:text-slate-600">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <form action="/add-expense" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Expense Title</label>
                        <input type="text" name="titre" placeholder="Coffee, Groceries, etc." required
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Category</label>
                        <select name="category" required class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                            <option value="">Select Category</option>
                            <option value="food">Food</option>
                            <option value="transport">Transport</option>
                            <option value="utilities">Utilities</option>
                            <option value="entertainment">Entertainment</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Amount</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                                <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                            </span>
                            <input type="number" name="depense" step="0.01" min="0" placeholder="0.00" required
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Expense Type</label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="type" value="depense" checked class="w-4 h-4 text-[#5D3FD3] focus:ring-[#5D3FD3]">
                                <span class="ml-2 text-slate-700">Normal Expense</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="type" value="autodepense" class="w-4 h-4 text-[#5D3FD3] focus:ring-[#5D3FD3]">
                                <span class="ml-2 text-slate-700">Auto Expense</span>
                            </label>
                        </div>
                    </div>

                    <div id="autoExpenseFields" class="hidden">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Day of Month</label>
                        <input type="number" name="day" min="1" max="31" placeholder="1"
                            class="w-full px-4 py-3 bg-white border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-violet-50 focus:border-[#5D3FD3] transition-all">
                        <p class="mt-1 text-xs text-slate-500">Day when this expense repeats monthly</p>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="button" onclick="closeExpenseModal()" class="flex-1 px-6 py-3 rounded-2xl bg-slate-100 font-semibold text-slate-600 hover:bg-slate-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-6 py-3 rounded-2xl bg-[#5D3FD3] text-white font-semibold hover:bg-[#4B32B3] transition">
                            Add Expense
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        let expenseCount = 1;
        
        function openBudgetModal() {
            document.getElementById('budgetModal').classList.remove('hidden');
        }
        
        function closeBudgetModal() {
            document.getElementById('budgetModal').classList.add('hidden');
        }
        
        function openExpenseModal() {
            document.getElementById('expenseModal').classList.remove('hidden');
        }
        
        function closeExpenseModal() {
            document.getElementById('expenseModal').classList.add('hidden');
        }
        
        // Toggle auto expense fields
        document.addEventListener('DOMContentLoaded', function() {
            const typeRadios = document.querySelectorAll('input[name="type"]');
            const autoFields = document.getElementById('autoExpenseFields');
            
            typeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'autodepense') {
                        autoFields.classList.remove('hidden');
                    } else {
                        autoFields.classList.add('hidden');
                    }
                });
            });
        });
        
        function addExpense() {
            const container = document.getElementById('autoExpenses');
            const newExpense = document.createElement('div');
            newExpense.className = 'expense-item grid grid-cols-1 md:grid-cols-4 gap-4 p-4 bg-slate-50 rounded-2xl';
            newExpense.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Expense Name</label>
                    <input type="text" name="auto_expenses[${expenseCount}][name]" placeholder="Rent, Netflix, etc."
                        class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5D3FD3]/20 focus:border-[#5D3FD3]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Category</label>
                    <select name="auto_expenses[${expenseCount}][category]" class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5D3FD3]/20 focus:border-[#5D3FD3]">
                        <option value="rent">Rent</option>
                        <option value="food">Food</option>
                        <option value="transport">Transport</option>
                        <option value="utilities">Utilities</option>
                        <option value="entertainment">Entertainment</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Amount</label>
                    <input type="number" name="auto_expenses[${expenseCount}][amount]" step="0.01" min="0" placeholder="0.00"
                        class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5D3FD3]/20 focus:border-[#5D3FD3]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Day of Month</label>
                    <input type="number" name="auto_expenses[${expenseCount}][day]" min="1" max="31" placeholder="1"
                        class="w-full px-3 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#5D3FD3]/20 focus:border-[#5D3FD3]">
                </div>
            `;
            container.appendChild(newExpense);
            expenseCount++;
        }
    </script>
</body>
</html>