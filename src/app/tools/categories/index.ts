import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { ApisService } from 'src/app/services/apis/apis.service';

@Injectable({
    providedIn: 'root'
  })
export class Categories implements CanActivate {

    constructor(private router: Router,private apis: ApisService) { }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        // console.log('this.apis.categories',this.apis.categories)
        if(this.apis.categories.length > 0){
            return true;
        }
        this.router.navigate(['']);
        return false;
    }
}