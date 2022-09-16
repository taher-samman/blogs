import { Component, OnInit } from '@angular/core';
import { Router} from '@angular/router';
import { ApisService } from 'src/app/services/apis/apis.service';
@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.less']
})
export class NavbarComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit(): void {
  }
  logout(){
    localStorage.removeItem('_blogsUser')
    localStorage.removeItem('_blogsToken')
    this.router.navigate(['login']);
  }
}