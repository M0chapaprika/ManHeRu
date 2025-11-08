@if(session('alert'))
    <div class="alert alert-{{ session('alert.type') }} alert-auto-close">
        <div class="alert-content">
            <span class="alert-icon">
                @switch(session('alert.type'))
                    @case('success') ✅ @break
                    @case('error') ❌ @break
                    @case('warning') ⚠️ @break
                    @case('info') ℹ️ @break
                @endswitch
            </span>
            <span class="alert-message">{{ session('alert.message') }}</span>
        </div>
        <button class="alert-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>

    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 300px;
            max-width: 500px;
            animation: slideIn 0.3s ease-out;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }

        .alert-info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        .alert-content {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .alert-icon {
            font-size: 16px;
        }

        .alert-message {
            flex: 1;
            font-weight: 500;
        }

        .alert-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: inherit;
            margin-left: 15px;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert-close:hover {
            opacity: 0.7;
        }

        .alert-auto-close {
            animation: slideIn 0.3s ease-out, slideOut 0.3s ease-in 4.7s forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
@endif