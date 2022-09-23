import { BehaviorSubject } from 'rxjs';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ApisService } from 'src/app/services/apis/apis.service';
import { Component, Input, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
@Component({
  selector: 'blog-comment',
  templateUrl: './comment.component.html',
  styleUrls: ['./comment.component.less']
})
export class CommentComponent implements OnInit {
  @Input('id') id: number = 0;
  @Input('loader') loaderSubject = new BehaviorSubject<boolean>(false);
  form = new FormGroup({
    comment: new FormControl()
  })
  constructor(private apis: ApisService, private _snackBar: MatSnackBar) { }

  ngOnInit(): void {
  }
  addComment() {
    this.loaderSubject.next(true);
    this.apis.addComment(this.form.value.comment, this.id).toPromise()
      .then(res => {
        if (res) {
          this.form.get('comment')?.setValue('');
          this._snackBar.open(`Success`, 'Success', { duration: 2000 })
        } else {
          this._snackBar.open(`Error Happened`, 'Error', { duration: 2000 })
        }
      })
      .finally(() => {
        this.apis.getComments();
        this.loaderSubject.next(false);
      }).catch(error => {
        this._snackBar.open(`Error ${error.error.message}`, 'Error', { duration: 3000 })
      });
  }
}
