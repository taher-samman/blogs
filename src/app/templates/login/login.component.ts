import { Component } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ApisService } from 'src/app/services/apis/apis.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Router} from '@angular/router';
@Component({
  selector: 'login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.less']
})
export class LoginComponent {
  form = new FormGroup({
    username: new FormControl('', [Validators.required]),
    password: new FormControl('', [Validators.required]),
  });
  progressBar = false;
  constructor(private apis: ApisService, private _snackBar: MatSnackBar,private router: Router) { }
  get username() {
    return this.form.get('username');
  }
  get password() {
    return this.form.get('password');
  }
  login() {
    this.progressBar = true;
    this.apis.login(this.form.value)
      .toPromise().then(res => {
        var data: any = { ...res };
        if (data['status']) {
          this._snackBar.open('Hello ' + data['user']['username'], 'Success', { duration: 2000, });
          localStorage.setItem('_blogsUser',JSON.stringify(data['user']));
          localStorage.setItem('_blogsToken',JSON.stringify(data['token']));
          this.router.navigate(['']);
        }
      }).catch(error => {
        this._snackBar.open(error.error.message, 'Error', { duration: 4000, });
      }).finally(() => {
        this.progressBar = false;
      })

  }
  register(){
    this.router.navigate(['register']);
  }
}
