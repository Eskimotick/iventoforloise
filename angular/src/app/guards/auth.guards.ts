import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot } from '@angular/router';
import { JwtHelperService } from '@auth0/angular-jwt';
import { AuthService } from '../services/auth.service';

const jwt = new JwtHelperService();

@Injectable()
export class AuthGuard implements CanActivate {

  constructor(public auth: AuthService, public router: Router) {}

  /**
   * Checa se rota pode ser acessada
   *
   * @return boolean
   */
  canActivate(route: ActivatedRouteSnapshot): boolean {
    const token = localStorage.getItem('token');

    if (jwt.isTokenExpired(token)) {
      this.router.navigate(['home']);
      return false;
    }

    if (route.data.expectedRole) {
      if (route.data.expectedRole !== jwt.decodeToken(token).fun) {
        this.router.navigate(['home']);
        return false;
      }
    }

    if (route.data.unexpectedRole) {
      if (route.data.unexpectedRole === jwt.decodeToken(token).fun) {
        this.router.navigate(['home']);
        return false;
      }
    }

    return true;
  }

}
