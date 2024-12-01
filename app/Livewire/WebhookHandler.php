<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Professional;
use Illuminate\Support\Facades\Log;

class WebhookHandler extends Component
{
    public $professionals;

    protected $listeners = ['professionalStatusUpdated' => 'refreshProfessionals'];

    public function mount()
    {
        $this->refreshProfessionals();

    }

    public function refreshProfessionals()
    {
        $this->professionals = Professional::all();
    }

    public function handleWebhook(Request $request)
    {
        Log::info('Received webhook:', $request->all());

        // Extract necessary data from the webhook payload
        $eventType = $request->input('event_type');
        $professionalId = $request->input('professional_id');

        if ($eventType === 'status_change') {
            // Update the status of the professional to 'red'
            Professional::where('id', $professionalId)->update(['status' => \DB::raw("CASE WHEN status = 'red' THEN 'green' ELSE 'red' END")]);

            $this->dispatch('professionalStatusUpdated'); // Emit an event
        }

        return response()->json(['status' => 'success']);
    }

    public function render()
    {
        return view('components.webhook-handler');
    }
}
