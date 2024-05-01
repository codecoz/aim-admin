<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use CodeCoz\AimAdmin\Constants\AG3;

trait APITrait
{
    use HelperTrait;

    public function getUserApplicationsByID(): array
    {

        $response = Http::request()->get(AG3::GET_APPLICATIONS, [
            'id' => config('aim-admin.auth.app_id')
        ]);

        if ($response->ok()) {
            return $this->getMultiValueFromArr($response->data);
        }
    }

    private function getUserInformation(array $accessKeys = [])
    {
        // Perform the API request once.
        $response = Http::request()->get(AG3::GET_USER_PAYLOAD, [
            'id' => Auth::id()
        ]);

        // Decode the JSON response.
        $response = json_decode($response->body());

        // Pre-verification to avoid repeated API calls.
        // Ensure $response and $response->data are valid.
        if (!isset($response->data)) {
            // Handle invalid response or data not set scenario.
            return []; // Or other appropriate default/error handling.
        }

        // Use match to return based on accessKeys.
        return match (true) {
            in_array('menu', $accessKeys) => is_array($response->data->menus) ? $response->data->menus : [],
            in_array('extraPermissions', $accessKeys) => is_array($response->data->extraPermissions) ? $response->data->extraPermissions : [],
            in_array('rolePermissions', $accessKeys) => is_array($response->data->rolePermissions) ? $response->data->rolePermissions : [],
            default => $response->data,
        };
    }

    function extractErrorSummary($text, bool $secondLevelError): string|null
    {
        $pattern = $secondLevelError ? '/"ErrorDescription"\s*:\s*\["([^"]+)"\]/' : '/"errorSummary"\s*:\s*"([^"]+)"/';
        if (preg_match($pattern, $text, $matches)) {
            return $matches[1];
        } else {
            return null;
        }
    }

    public function roleHasUserList(): array
    {
        $response = Http::request()->get(AG3::GET_USERS_ROLES)->json();
        return $this->getUserByRole($this->setToArray($response['data']));
    }
}
