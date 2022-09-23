import { Component, OnInit } from '@angular/core';
import { Router} from '@angular/router';
import { ApisService } from 'src/app/services/apis/apis.service';
@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.less']
})
export class NavbarComponent implements OnInit {
  user:any;
  constructor(private router: Router) { 
    var user:any = localStorage.getItem('_blogsUser');
    this.user = JSON.parse(user);
  }

  ngOnInit(): void {
  }
  logout(){
    localStorage.removeItem('_blogsUser')
    localStorage.removeItem('_blogsToken')
    this.router.navigate(['login']);
  }
}
