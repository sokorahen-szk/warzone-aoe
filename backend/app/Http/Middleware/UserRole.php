<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Config;
use Package\Domain\User\Repository\UserRepositoryInterface;
use Package\Domain\User\ValueObject\UserId;
use Exception;

class UserRole
{
    private $userRepository;
    private $rolePathConfigs;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = new $userRepository;
        $this->rolePathConfigs = Config::get('role');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $pos = $this->indexOf($request->path());

        if ($pos !== -1) {
            $user = $this->userRepository->findUserById(new UserId(Auth::user()->id));
            if ($user->getRole()->getRoleLevel()->getValue() < $this->rolePathConfigs[$pos]['level']) {
                throw new Exception(
                    sprintf("%s にアクセスする権限がありません", $this->rolePathConfigs[$pos]['label'])
                );
            }
        }

        return $next($request);
    }

    private function indexOf(string $currentPath): int
    {
        foreach ($this->rolePathConfigs as $pos => $rolePathConfig) {
            $pattern = sprintf("|^api/%s$|", $rolePathConfig['path']);
            if (preg_match_all($pattern, $currentPath)) {
                return $pos;
            }
        }

        return -1;
    }
}
