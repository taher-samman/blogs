import { Injectable } from '@angular/core';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { ApisService } from 'src/app/services/apis/apis.service';
import { DataService } from 'src/app/services/data/data.service';

@Injectable({
    providedIn: 'root'
})
export class Blogs implements CanActivate {

    constructor(private router: Router, private data: DataService) { }

    canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot) {
        // if (this.data.blogs.length > 0) {
        //     return true;
        // }
        this.router.navigate(['']);
        return false;
    }
}