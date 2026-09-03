import { cn } from "@/lib/utils";

interface DialogContentProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const DialogContent = React.forwardRef<HTMLDivElement, DialogContentProps>({
  className: "py-2 px-3 bg-background rounded-lg shadow-sm transition-shadow focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2",
  ...props,
}) => {
  return (
    <div className={cn("py-2 px-3 bg-background rounded-lg shadow-sm transition-shadow focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2", props.className)} {...props} />
  );
});

DialogContent.displayName = "DialogContent";

interface DialogHeaderProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const DialogHeader = React.forwardRef<HTMLDivElement, DialogHeaderProps>({
  className: "flex flex-row items-start justify-between gap-4 pb-2",
  ...props,
}) => {
  return (
    <div className={cn("flex flex-row items-start justify-between gap-4 pb-2", props.className)} {...props} />
  );
});

DialogHeader.displayName = "DialogHeader";

interface DialogFooterProps extends React.HTMLAttributes<HTMLDivElement> {
  className?: string;
}

const DialogFooter = React.forwardRef<HTMLDivElement, DialogFooterProps>({
  className: "flex flex-row-reverse gap-2 pt-2",
  ...props,
}) => {
  return (
    <div className={cn("flex flex-row-reverse gap-2 pt-2", props.className)} {...props} />
  );
});

DialogFooter.displayName = "DialogFooter";

interface DialogProps extends React.DialogHTMLAttributes<HTMLDivElement> {
  className?: string;
}

const Dialog = React.forwardRef<HTMLDivElement, DialogProps>({
  className: "max-w-sm",
  ...props,
}) => {
  return (
    <div className={cn("max-w-sm", props.className)} {...props} />
  );
});

Dialog.displayName = "Dialog";

interface DialogTriggerProps extends React.HTMLAttributes<HTMLButtonElement> {
  className?: string;
}

const DialogTrigger = React.forwardRef<HTMLButtonElement, DialogTriggerProps>({
  className: "inline-flex items-center justify-center rounded-md border bg-input px-3 py-1.5 text-sm font-medium hover:bg-accent",
  ...props,
}) => {
  return (
    <button className={cn("inline-flex items-center justify-center rounded-md border bg-input px-3 py-1.5 text-sm font-medium hover:bg-accent", props.className)} {...props} />
  );
});

DialogTrigger.displayName = "DialogTrigger";

export { Dialog, DialogTrigger, DialogContent, DialogHeader, DialogFooter };
