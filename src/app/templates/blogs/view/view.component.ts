import { filter } from 'rxjs';
import { DataService } from './../../../services/data/data.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { LoaderService } from './../../../services/loader/loader.service';
import { ApisService } from 'src/app/services/apis/apis.service';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-view',
  templateUrl: './view.component.html',
  styleUrls: ['./view.component.less']
})
export class ViewComponent implements OnInit {
  blog: any = 0;
  likes: (any)[] = [];
  comments: (any)[] = [];
  constructor(private data: DataService, private _snackBar: MatSnackBar, private router: Router, private route: ActivatedRoute, private apis: ApisService, private loader: LoaderService) {
    this.loader.show.next(true);
    const id: any = this.route.snapshot.paramMap.get('id')
    this.apis.getBlog(id).toPromise()
      .then(res => {
        var data: any = { ...res };
        if (data['status']) {
          this.blog = data['data'];
        }
      })
      .finally(() => {
        this.apis.getLikes();
        this.apis.getComments();
        this.loader.show.next(false)
      });
    this.data.blogsLikes.subscribe(res => {
      var data: any = { ...res };
      data = data[id];
      if (data != undefined) {
        var users = data['users'];
        this.likes = users;
      } else {
        this.likes = [];
      }
    })
    this.data.blogsComments.subscribe(res => {
      var data: any = res;
      var comments = data.filter((d: any) => Number(d.blog_id) === Number(id));
      this.comments = comments;
    })
  }
  canEdit() {
    var user: any = localStorage.getItem('_blogsUser');
    user = JSON.parse(user);
    if (this.blog.user_id == user.id) {
      return true;
    }
    return false;
  }
  delete() {
    if (confirm("Are you sure to delete this blog?")) {
      if (confirm('this blog will deleted!!!')) {
        this.apis.deleteBlog(Number(this.blog.id)).toPromise()
          .then(res => {
            this._snackBar.open(`Blog Removed SUCCESSFLY`, 'Success', { duration: 2000, });
            this.router.navigate(['blogs'])
          });
      }
    }
  }
  ngOnInit(): void {
  }
  removeImage(id: any) {
    id = Number(id);
    if (confirm('are you sure ! you want to emove this image?')) {
      this.apis.removeImage(id).toPromise()
        .then(res => {
          if (res) {
            this.apis.getBlog(this.blog.id).toPromise()
              .then(res => {
                var data: any = { ...res };
                if (data['status']) {
                  this.blog = data['data'];
                }
              })
              .finally(() => {
                this.apis.getLikes();
                this.apis.getComments();
                this.loader.show.next(false)
              });
          }
        }).catch(error => {
          this._snackBar.open('error ' + error.error.message, 'Error', { duration: 4000 })
        })
    }
  }
}
