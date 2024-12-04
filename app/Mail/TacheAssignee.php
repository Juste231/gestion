namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TacheAssignee extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($task, $user)
    {
        $this->task = $task;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tâche Assignée - ' . $this->task->titre,  // Sujet dynamique avec le titre de la tâche
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.tache_assignee',  // Votre vue Blade pour l'email
            data: [
                'task' => $this->task,  // Passer la tâche à la vue
                'user' => $this->user,  // Passer l'utilisateur à la vue
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
