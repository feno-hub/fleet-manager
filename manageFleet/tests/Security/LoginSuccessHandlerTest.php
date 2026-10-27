<?php

namespace App\Tests\Security;

use App\Entity\User;
use App\Security\LoginSuccessHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LoginSuccessHandlerTest extends TestCase
{
    public function testAdminIsRedirectedToAdminDashboard(): void
    {
        $user = (new User())->setRoles(['ROLE_ADMIN']);
        $token = $this->createStub(TokenInterface::class);
        $token->method('getUser')->willReturn($user);

        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator->expects($this->once())
            ->method('generate')
            ->with('admin_dashboard')
            ->willReturn('/admin/dashboard');

        $response = (new LoginSuccessHandler($urlGenerator))
            ->onAuthenticationSuccess(new Request(), $token);

        self::assertNotNull($response);
        self::assertSame('/admin/dashboard', $response->headers->get('Location'));
    }

    public function testRegularUserIsRedirectedToDashboard(): void
    {
        $user = new User();
        $token = $this->createStub(TokenInterface::class);
        $token->method('getUser')->willReturn($user);

        $urlGenerator = $this->createMock(UrlGeneratorInterface::class);
        $urlGenerator->expects($this->once())
            ->method('generate')
            ->with('dashboard')
            ->willReturn('/dashboard');

        $response = (new LoginSuccessHandler($urlGenerator))
            ->onAuthenticationSuccess(new Request(), $token);

        self::assertNotNull($response);
        self::assertSame('/dashboard', $response->headers->get('Location'));
    }
}
