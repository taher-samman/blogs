import { DataService } from './../../../services/data/data.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { BehaviorSubject } from 'rxjs';
import { LoaderService } from './../../../services/loader/loader.service';
import { ApisService } from 'src/app/services/apis/apis.service';
import { Component, Input, OnInit } from '@angular/core';

@Component({
  selector: 'blog-like',
  templateUrl: './like.component.html',
  styleUrls: ['./like.component.less']
})
export class LikeComponent implements OnInit {
  @Input('id') id: number = 0;
  liked: boolean = false;
  nbLikes: number = 0;
  @Input('loader') loaderSubject = new BehaviorSubject<boolean>(false);
  constructor(private apis: ApisService, private loader: LoaderService, private _snackBar: MatSnackBar, private data: DataService) {
    this.data.blogsLikes.subscribe(res => {
      var data: any = { ...res };
      data = data[this.id];
      if (data != undefined) {
        // console.log(`post ${this.id} qty ${data['qty']}`);
        this.nbLikes = data['qty'];
        var user: any = localStorage.getItem('_blogsUser');
        user = JSON.parse(user);
        var users = data['users'];
        // if (users.includes(user['id'])) {
        //   this.liked = true;
        // } else {
        //   this.liked = false;
        // }
        if (users.find((u: any) => u.id === user['id'])) {
          this.liked = true;
        } else {
          this.liked = false;
        }
      } else {
        this.nbLikes = 0;
        this.liked = false;
      }
    })
  }

  ngOnInit(): void {
  }
  changeLiked() {
    this.liked = !this.liked;
  }
  like() {
    this.loaderSubject.next(true);
    if (this.liked) {
      // removeLike
      this.apis.removeLike(this.id).toPromise()
        .then(res => {
          if (res) {
            this.liked = false;
          } else {
            this.liked = true;
          }
        })
        .finally(() => {
          this.apis.getLikes();
          this.loaderSubject.next(false);
        }).catch(error => {
          this.liked = true;
          this._snackBar.open(`Error ${error.error.message}`, 'Error', { duration: 3000 })
        });
    } else {
      // addLike
      this.apis.addLike(this.id).toPromise()
        .then(res => {
          if (res) {
            this.liked = true;
          } else {
            this.liked = false;
          }
        })
        .finally(() => {
          this.apis.getLikes();
          this.loaderSubject.next(false);
        }).catch(error => {
          this.liked = false;
          this._snackBar.open(`Error ${error.error.message}`, 'Error', { duration: 3000 })
        });
    }
  }
}
